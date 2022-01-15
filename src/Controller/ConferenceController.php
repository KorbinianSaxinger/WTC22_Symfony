<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Conference;
use App\Repository\ConferenceRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }

    #[Route('/hamburg', name: 'hamburg')]
    public function index(ManagerRegistry $doctrine): Response
    {
        echo"
            <style>
            #commentField{
                border-style: solid;
                border-color: dodgerblue;
                border-radius: 0.8px;
                margin-top: 5px;
            }            
            #conferenceField{
                text-align: center;
                width: 500px;
                height: 215px;
                border-style: solid;
                border-color: dodgerblue;
                border-radius: 0.8px;
                margin-top: 5px;
            }
            #confList{
                width: 350px;
                height: 215px;
                border-style: solid;
                border-color: dodgerblue;
                border-radius: 0.8px;
                margin-top: -234px;
                margin-left: 950px; 
            }
            #credits{
                width: 310px;
                height: 215px;
                border-style: solid;
                border-color: dodgerblue;
                border-radius: 0.8px;
                margin-top: -234px;
                margin-left: 1350px; 
            }
            #comment{
            width: 350px;
            height: 215px;
                border-style: solid;
                border-color: dodgerblue;
                border-radius: 0.8px;
                margin-top: -234px;
                margin-left: 550px; 
                
            }
            </style>
        ";

        echo"<a href='berlin'> Berlin </a>";
        $repository = $this->em->getRepository(Conference::class);
        $conferences = $repository->find(1);
        echo"<br>
                <fieldset id='conferenceField'>
                <h1>Konferenz: ".$conferences->getCity()."</h1><h2>Jahr: ".$conferences->getYear()."</h2><h3>International: "
            .$conferences->getInternational()."<h3></h3><br>";
        echo"</fieldset>";


        echo"
        <style>
            #text{
                width:307px;
                height: 100px;
            }
            #commentForm{
                text-align: left;
                margin-left: 0px;
            }
            #berlinl {
                margin-left: 85px;
                
            }#hamburgl {
                margin-left: 3px;
            }
             #email{
                 margin-left: 20px;
             }
        </style>
    <fieldset id='comment'>
    <form method ='POST'>
            </div>
                <p>Neues Kommentar:</p>
            
                <input type='text' name='author' value='author'/><input type='text' id='email' name='email' value='email'/>
            <br><br>
            <textarea id='text' name='text' rows='10' cols='250'>Kommentar max 1.500 Zeichen.
            </textarea><br>
            <input type='submit' id='sub' name='sub' value='Senden'>
            </form>
            
            
    </fieldset>
        ";


        echo"
            <fieldset id='confList'>
            <h2>Konferenzen 2022</h2>
            <ul>
        ";
        $repository = $this->em->getRepository(Conference::class);
        $cnt = $repository->createQueryBuilder('u')
            ->select('count(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
        $repository3 = $this->em->getRepository(Conference::class);
        $name = $repository3->findAll();
        for($i = 0; $i < $cnt; $i++) {
            $stadt = $name[$i]->getCity();
            $link = strtolower($stadt);
            echo "<li><a href='$link'>$stadt</a></li>";
        }
        echo"
            </ul>
            </fieldset>
        ";

        echo"
        <fieldset id='credits'>
        <h3>Aufgabe: Kommentar Seite</h3>
        <h3>Author: Korbinian Saxinger</h3>
        <h3>Thanks to:</h3> <p> YoutTube für meine Symfony 'Skills' und meinen Ausbildern die<br> mir HTML,PHP und CSS beigebracht haben</p>
        </fieldset>
        ";

        if(isset($_POST['sub'])) {
            $mail = $_POST['email'];

            if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                echo"<h2>Bitte eine gültige E-mail eingeben.</h2>";
            } else{
                    $repository = $this->em->getRepository(Comment::class);
                    $conf = $repository->findOneBy(['conference' => 1]);
                    $entityManager = $doctrine->getManager();

                $comment = new Comment();
                $comment->setAuthor($_POST["author"]);
                $comment->setEmail($_POST["email"]);
                $comment->setConference($conf->getConference());
                $comment->setText($_POST["text"]);

                $entityManager->persist($comment);
                $entityManager->flush();
                echo"Kommentar von ".$comment->getAuthor(). " hinzugefüg.";

            }
        }

        $repository2 = $this->em->getRepository(Comment::class);
        $all = $repository2->count(['conference' => 1]);
        $comment = $repository2->findBy(['conference' => 1],[]);
        for($i = 0;$i<$all;$i++){
            $count = $i+1;
            echo"<fieldset id='commentField'>";
            echo"Kommentar " .$count. "<br>Author: ".$comment[$i]->getAuthor()."<br>
                    E-Mail: ".$comment[$i]->getEmail()."<br>Kommentar:<br>".$comment[$i]->getText()."</fieldset>";

        }
        return $this->render('index.html.twig');
    }



    #[Route('/berlin', name: 'berlin')]
    public function berlin(ManagerRegistry $doctrine): Response
    {
        echo"
<style>
            #commentField{
                border-style: solid;
                border-color: dodgerblue;
                border-radius: 0.8px;
                margin-top: 5px;
            }            
            #conferenceField{
                text-align: center;
                width: 500px;
                height: 215px;
                border-style: solid;
                border-color: dodgerblue;
                border-radius: 0.8px;
                margin-top: 5px;
            }
             #confList{
                width: 350px;
                height: 215px;
                border-style: solid;
                border-color: dodgerblue;
                border-radius: 0.8px;
                margin-top: -234px;
                margin-left: 950px; 
            }
            #credits{
                width: 310px;
                height: 215px;
                border-style: solid;
                border-color: dodgerblue;
                border-radius: 0.8px;
                margin-top: -234px;
                margin-left: 1350px; 
            }
            #comment{
            width: 350px;
            height: 215px;
                border-style: solid;
                border-color: dodgerblue;
                border-radius: 0.8px;
                margin-top: -234px;
                margin-left: 550px; 
                
            }
            </style>
        ";

        echo"<a href='hamburg'> Hamburg </a><fieldset id='conferenceField'>";
        $repository = $this->em->getRepository(Conference::class);
        $conferences = $repository->find(2);
        echo"<h1>Konferenz: ".$conferences->getCity()."</h1><h2>Jahr: ".$conferences->getYear()."</h2><h3>International: ".$conferences->getInternational()."<h3></h3><br>";
        echo"</fieldset>";


        echo"
        <style>
            #text{
                width:307px;
                height: 100px;
            }
            #commentForm{
                text-align: left;
                margin-left: 0px;
            }
            #berlinl {
                margin-left: 85px;
                
            }#hamburgl {
                margin-left: 3px;
            }
             #email{
                 margin-left: 20px;
             }
        </style>
        
    <fieldset id='comment'>
    <form method ='POST'>
            </div>
                <p>Neues Kommentar:</p>
            
                <input type='text' name='author' value='author'/><input type='text' id='email' name='email' value='email'/>
            <br><br>
            <textarea id='text' name='text' rows='10' cols='250'>Kommentar max 1.500 Zeichen.
            </textarea><br>
            <input type='submit' id='sub' name='sub' value='Senden'>
            </form>
            
            
    </fieldset>
        ";

        echo"
            <fieldset id='confList'>
            <h2>Konferenzen 2022</h2>
            <ul>
        ";
        $repository = $this->em->getRepository(Conference::class);
        $cnt = $repository->createQueryBuilder('u')
            ->select('count(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
        $repository3 = $this->em->getRepository(Conference::class);
        $name = $repository3->findAll();
        for($i = 0; $i < $cnt; $i++) {
            $stadt = $name[$i]->getCity();
            $link = strtolower($stadt);
            echo "<li><a href='$link'>$stadt</a></li>";
        }
        echo"
            </ul>
            </fieldset>
        ";

        echo"
        <fieldset id='credits'>
        <h3>Aufgabe: Kommentar Seite</h3>
        <h3>Author: Korbinian Saxinger</h3>
        <h3>Thanks to:</h3> <p> YoutTube für meine Symfony 'Skills' und meinen Ausbildern die<br> mir HTML,PHP und CSS beigebracht haben</p>
        </fieldset>
        ";

        if(isset($_POST['sub'])) {
            $mail = $_POST['email'];

            if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                echo"<h2>Bitte eine gültige E-mail eingeben.</h2>";
            } else{
                $repository = $this->em->getRepository(Comment::class);
                $conf = $repository->findOneBy(['conference' => 2]);
                $entityManager = $doctrine->getManager();

                $comment = new Comment();
                $comment->setAuthor($_POST["author"]);
                $comment->setEmail($_POST["email"]);
                $comment->setConference($conf->getConference());
                $comment->setText($_POST["text"]);

                $entityManager->persist($comment);
                $entityManager->flush();
                echo"Kommentar von ".$comment->getAuthor(). " hinzugefüg.";

            }
        }
        $repository2 = $this->em->getRepository(Comment::class);
        $all = $repository2->count(['conference' => 2]);
        $comment = $repository2->findBy(['conference' => 2],[]);
        for($i = 0;$i<$all;$i++){
            $count = $i+1;
            echo"<fieldset id='commentField'>";
            echo"Kommentar " .$count. "<br>Author: ".$comment[$i]->getAuthor()."<br>
                    E-Mail: ".$comment[$i]->getEmail()."<br>Kommentar:<br>".$comment[$i]->getText()."</fieldset>";

        }
        return $this->render('index.html.twig');
    }
}

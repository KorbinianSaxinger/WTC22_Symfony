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
use function Composer\Autoload\includeFile;

class ConferenceController extends AbstractController
{

    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }
    public function showConference(int $id){
        echo"<fieldset id='conferenceField'>";
        $repository = $this->em->getRepository(Conference::class);
        $conferences = $repository->find($id);
        if($conferences->getInternational()== true){
            $inter = "Ja";
        }else{
            $inter = "Nein";
        }
        echo"<h1>Technology Conference:<br>".$conferences->getCity()."</h1><h2>Jahr: ".$conferences->getYear()."</h2><h3>International: ".$inter."<h3></h3><br>";
        echo"</fieldset>";

    }
    public function deleteComment(int $conference){
        #Kommentare Löschen Funktion#
        $repository = $this->em->getRepository(Comment::class);
        $cnt = $repository->count(['conference' => $conference]);
        $comment = $repository->findBy(['conference' => $conference],[]);

        for($i=0;$i<$cnt;$i++){
            $getID = $comment[$i]->getId();
            if(isset($_POST["dl$getID"])){
                $repository = $this->em->getRepository(Comment::class);
                $rem = $repository->find($getID);
                $this->em->remove($rem);
                $this->em->flush();
            }
        }
    }
    public function formAddComment(){
        echo" 
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

    }
    public function conferenceList(){
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
        $name = $repository->findAll();
        for($i = 0; $i < $cnt; $i++) {
            $stadt = $name[$i]->getCity();
            $link = strtolower($stadt);
            echo "<li><a href='$link'>$stadt</a></li>";
        }
        echo"
            </ul>
            </fieldset>
        ";
    }
    public function credits(){
        echo"
        <fieldset id='credits'>
        <h3>Aufgabe: Kommentar Seite</h3>
        <h3>Name: Korbinian Saxinger</h3>
        <h3>Thanks to:</h3> <p>webconia, besonders Mareike, ohne die ich diese Chance nicht hätte. :)<br> YouTube für meine Symfony 'Skills' <br>und meinen Ausbildern die mir HTML,PHP und CSS beigebracht haben</p>
        </fieldset>
        ";
    }
    public function addComment(ManagerRegistry $doctrine, int $conference){
        if(isset($_POST['sub'])) {
            $mail = $_POST['email'];

            if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                echo"<h2 id='wrongMail'>Bitte eine gültige E-mail eingeben!</h2>";
            } else{
                $repository = $this->em->getRepository(Comment::class);
                $conf = $repository->findOneBy(['conference' => $conference]);
                $entityManager = $doctrine->getManager();

                $comment = new Comment();
                $comment->setAuthor($_POST["author"]);
                $comment->setEmail($_POST["email"]);
                $comment->setConference($conf->getConference());
                $comment->setText($_POST["text"]);

                $entityManager->persist($comment);
                $entityManager->flush();
                echo"<fieldset id='addComment'>Kommentar von ".$comment->getAuthor(). " hinzugefüg.</fieldset>";

            }
        }
    }
    public function showComments(int $conference){
        $repository = $this->em->getRepository(Comment::class);
        $all = $repository->count(['conference' => $conference]);
        $comment = $repository->findBy(['conference' => $conference],[]);
        for($i = 0;$i<$all;$i++){
            $count = $i+1;
            $getit = $comment[$i]->getId();
            echo"<fieldset id='commentField'>";
            echo"Kommentar " .$count. "<br>Author: ".$comment[$i]->getAuthor()."<br>
                    E-Mail: ".$comment[$i]->getEmail()."<br>Kommentar:<br>".$comment[$i]->getText()."
                   <form method='POST'><input type='submit' id='dl$getit' name='dl$getit' value='Löschen'></form> 
                    </fieldset>";

        }
    }
    public function styleSheet(){
        echo"
<style>
            #commentField{
                font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
                color:rgb(105, 105, 105);
                width:auto;
                border-style: solid;
                border-color: dodgerblue;
                border-radius: 0.8px;
                margin-top: 5px;
            }              
            #addComment{
                font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
                color:rgb(105, 105, 105);
                width:auto;
                border-style: solid;
                border-color: dodgerblue;
                border-radius: 0.8px;
                margin-top: 5px;
            }            
            #conferenceField{
                font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
                color:rgb(105, 105, 105);
                text-align: center;
                width: 500px;
                height: 215px;
                border-style: solid;
                border-color: dodgerblue;
                border-radius: 0.8px;
                margin-top: 5px;
            }
             #confList{
                font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
                color:rgb(105, 105, 105);
                width: 350px;
                height: 215px;
                border-style: solid;
                border-color: dodgerblue;
                border-radius: 0.8px;
                margin-top: -235px;
                margin-left: 930px; 
            }
            #credits{
                font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
                color:rgb(105, 105, 105);
                width: auto;
                height: 215px;
                border-style: solid;
                border-color: dodgerblue;
                border-radius: 0.8px;
                margin-top: -235px;
                margin-left: 1318px; 
            }
            #credits > p{
                margin-top:-20px ;
            }
            #comment{
                font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
                color:rgb(105, 105, 105);
                width: 350px;
                height: 215px;
                border-style: solid;
                border-color: dodgerblue;
                border-radius: 0.8px;
                margin-top: -234px;
                margin-left: 540px; 
                
            }
            #wrongMail{        
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color:rgb(105, 105, 105);
            text-align: center;
            }
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
        ";
    }

    #[Route('/hamburg', name: 'hamburg')]
    public function index(ManagerRegistry $doctrine): Response
    {

    $this->styleSheet();
    $this->showConference(1);
    $this->deleteComment(1);
    $this->formAddComment();
    $this->conferenceList();
    $this->credits();
    $this->addComment($doctrine,1);
    $this->showComments(1);

        return $this->render('index.html.twig');
    }



    #[Route('/berlin', name: 'berlin')]
    public function berlin(ManagerRegistry $doctrine): Response
    {
        $this->styleSheet();
        $this->showConference(2);
        $this->deleteComment(2);
        $this->formAddComment();
        $this->conferenceList();
        $this->credits();
        $this->addComment($doctrine,2);
        $this->showComments(2);
        return $this->render('index.html.twig');
    }
}

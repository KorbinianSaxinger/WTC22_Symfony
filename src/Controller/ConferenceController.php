<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Conference;
use App\Repository\ConferenceRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(): Response
    {

        echo"<a href='berlin'> Berlin </a>";
        $repository = $this->em->getRepository(Conference::class);
        $conferences = $repository->find(1);
        echo"<br><h1>Konferenz: ".$conferences->getCity()."</h1><h2>Jahr: ".$conferences->getYear()."</h2><h3>International: ".$conferences->getInternational()."<h3></h3><br>";
        echo"<a href='comment'> Kommentieren </a>";

        $repository2 = $this->em->getRepository(Comment::class);
        $all = $repository2->count(['conference' => 1]);
        $comment = $repository2->findBy(['conference' => 1],[]);
        for($i = 0;$i<$all;$i++){
            $count = $i+1;
            echo"<hr>";
            echo"Kommentar " .$count. "<br>Author: ".$comment[$i]->getAuthor()."<br>
                    E-Mail: ".$comment[$i]->getEmail()."<br>Kommentar:<br>".$comment[$i]->getText();

        }
        return $this->render('index.html.twig');
    }
    #[Route('/berlin', name: 'berlin')]
    public function berlin(): Response
    {
        echo"<a href='hamburg'> Hamburg </a>";
        $repository = $this->em->getRepository(Conference::class);
        $conferences = $repository->find(2);
        echo"<br><h1>Konferenz: ".$conferences->getCity()."</h1><h2>Jahr: ".$conferences->getYear()."</h2><h3>International: ".$conferences->getInternational()."<h3></h3><br>";
        echo"<a href='comment'> Kommentieren </a>";

        $repository2 = $this->em->getRepository(Comment::class);
        $all = $repository2->count(['conference' => 2]);
        $comment = $repository2->findBy(['conference' => 2],[]);
        for($i = 0;$i<$all;$i++){
            $count = $i+1;
            echo"<hr>";
            echo"Kommentar " .$count. "<br>Author: ".$comment[$i]->getAuthor()."<br>
                    E-Mail: ".$comment[$i]->getEmail()."<br>Kommentar:<br>".$comment[$i]->getText();

        }
        return $this->render('index.html.twig');
    }
}

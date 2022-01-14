<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Conference;
use App\Repository\ConferenceRepository;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
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
        $repository = $this->em->getRepository(Conference::class);
        $conferences = $repository->find(1);


        $repository2 = $this->em->getRepository(Comment::class);
        $comment = $repository2->findBy(['conference' => 1],[]);
        dd($conferences,$comment);

        return $this->render('index.html.twig');
    }
    #[Route('/berlin', name: 'berlin')]
    public function berlin(): Response
    {
        $repository = $this->em->getRepository(Conference::class);
        $conferences = $repository->find(2);


        $repository2 = $this->em->getRepository(Comment::class);
        $comment = $repository2->findBy(['conference' => 2],[]);
        dd($conferences,$comment);



        return $this->render('index.html.twig');
    }
}

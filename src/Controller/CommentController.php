<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Conference;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method getDoctrine()
 */
class CommentController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }
    #[Route('/berlin-comment', name: 'Comment Berlin')]
    public function commentB(Request $request, ManagerRegistry $doctrine)
    {
        $form = $this->createForm(CommentType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $repository = $this->em->getRepository(Comment::class);
            $conference = $repository->findOneBy(['conference' => 2]);
            #$commentData = $form->getData();
                $entityManager = $doctrine->getManager();
                $comment = new Comment();
                $comment->setAuthor($_POST["author"]);
                $comment->setEmail($_POST["email"]);
                $comment->setConference($conference->getConference());
                $comment->setText($_POST["text"]);

                $entityManager->persist($comment);
                $entityManager->flush();
            return new Response("Kommentar von ".$comment->getAuthor()." hinzugefügt");
            #dd($commentData);

        }
            #dump($request);             //Anzeige Request

       return $this->render('comment/comment.html.twig', [
           'our_form' => $form->createView()
       ]);
    }

    #[Route('/hamburg-comment', name: 'comment Hamburg')]
    public function comment(Request $request, ManagerRegistry $doctrine)
    {
        $form = $this->createForm(CommentType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $repository = $this->em->getRepository(Comment::class);
            $conference = $repository->findOneBy(['conference' => 1]);
            #$commentData = $form->getData();
            $entityManager = $doctrine->getManager();
            $comment = new Comment();
            $comment->setAuthor($_POST["author"]);
            $comment->setEmail($_POST["email"]);
            $comment->setConference($conference->getConference());
            $comment->setText($_POST["text"]);

            $entityManager->persist($comment);
            $entityManager->flush();
            return new Response("Kommentar von ".$comment->getAuthor(). " hinzugefügt");
            #dd($commentData);

        }
        #dump($request);             //Anzeige Request

        return $this->render('comment/comment.html.twig', [
            'our_form' => $form->createView()
        ]);
    }
}

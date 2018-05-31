<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RedditPost;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RedditController extends Controller
{
    /**
     * @Route("/reddit", name="reddit")
     */
    public function listAction()
    {
        $posts = $this->getDoctrine()->getRepository('AppBundle:RedditPost')->findAll();

        return $this->render('reddit/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/create_reddit/{text}", name="create_reddit")
     */
    public function createAction($text){

        $em = $this->getDoctrine()->getManager();

        $post = new RedditPost();
        $post->setTitle('hello ' . $text);

        $em->persist($post);
        $em->flush();

        return $this->redirectToRoute('reddit');

    }

    /**
     * @Route("/update_reddit/{id}/{text}", name="update")
     */
    public function updateAction($id, $text)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('AppBundle:RedditPost')->find($id);

        if (!$post) {
            throw $this->createNotFoundException('thats not a record');
        }

        /** @var $post RedditPost */
        $post->setTitle('updated title ' . $text);

        $em->flush();

        return $this->redirectToRoute('reddit');
    }

    /**
     * @Route("/delete_reddit/{id}", name="delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('AppBundle:RedditPost')->find($id);

        if (!$post) {
            return $this->redirectToRoute('list');
        }

        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('reddit');
    }


}
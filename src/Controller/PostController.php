<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/post", name="post.")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();

        dump($posts);

        return $this->render('index.html.twig', ['posts' => $posts]);

        // return $this->json([
        //     'message' => 'Welcome to your new controller!',
        //     'path' => 'src/Controller/PostController.php',
        // ]);
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request) // create a new post
    {
        $post = new Post();

        $post->setTitle("This is the title I was looking for.");

        $em = $this->getDoctrine()->getManager(); // entity manager

        $em->persist($post);

        $em->flush();

        return new Response("Post has been created!");
    }
}

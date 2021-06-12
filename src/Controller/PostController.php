<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
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
        try {
            $post = new Post();
            
            $form = $this->createForm(PostType::class, $post);
    
            $form->handleRequest($request);
            
            if ($form->isSubmitted()) {
                if($post->getName() == "" || $post->getEmail() == "" || $post->getMessage() == ""){
                    $this->addFlash(
                        'error',
                        'Hiba! Kérlek töltsd ki az összes mezőt!'
                    );
                }
                else{ // $form->isValid()
                    $em = $this->getDoctrine()->getManager(); // entity manager
                    
                    $em->persist($post);
                    $em->flush();
        
                    $this->addFlash(
                       'success',
                       'Köszönjük szépen a kérdésedet.'
                    );
                }
            }
            return $this->render('create.html.twig', ['form' => $form->createView()]);
        } catch (\Exception $th) {
            return $this->render('create.html.twig', ['error' => $th->getMessage()]);
        }

    }
}

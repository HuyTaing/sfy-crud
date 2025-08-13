<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{
    #[Route('/posts', name: 'posts_index', methods: ['GET'])]
    public function index(PostRepository $postRepo): Response
    {
        $posts = $postRepo->findAll();
        return $this->render('pages/post/index.html.twig', [
            'posts' => $posts
        ]);
    }

    #[Route('/posts/create', name: 'posts_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('posts_index');
        }

        return $this->render('pages/post/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/posts/{id}', name: 'posts_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('pages/post/show.html.twig', [
            'post' => $post
        ]);
    }

    #[Route('/posts/{id}/edit', name: 'posts_edit', methods: ['GET', 'POST'])]
    public function edit(Post $post, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('posts_index');
        }

        return $this->render('pages/post/edit.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
        ]);
    }

    #[Route('/posts/{id}/delete', name: 'posts_delete', methods: ['DELETE'])]
    public function delete(Post $post,Request $request, EntityManagerInterface $em)
    {
        if($this->isCsrfTokenValid('DEL' . $post->getId(), $request->get('_token')) )
        {
            $em->remove($post);
            $em->flush();

            return $this->redirectToRoute('posts_index');
        }

    }
}

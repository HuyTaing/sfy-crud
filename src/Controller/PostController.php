<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{
    #[Route('/posts', name: 'posts_index', methods: ['GET'])]
    public function index(PostRepository $postRepo): Response
    {
        $posts = $postRepo->findAll();

        // dd($posts);
        return $this->render('pages/post/index.html.twig', [
            'posts' => $posts
        ]);
    }
}

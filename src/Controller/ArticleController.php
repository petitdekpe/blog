<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    #[Route('/article/{slug}', name: 'app_article')]
    public function show(
        string $slug,
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository
    ): Response {
        $article = $articleRepository->findBySlug($slug);

        if (!$article) {
            throw $this->createNotFoundException('Article non trouvé');
        }

        $categories = $categoryRepository->findAll();

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'categories' => $categories,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/{slug}', name: 'app_category')]
    public function show(
        string $slug,
        CategoryRepository $categoryRepository,
        ArticleRepository $articleRepository
    ): Response {
        $category = $categoryRepository->findOneBy(['slug' => $slug]);

        if (!$category) {
            throw $this->createNotFoundException('Catégorie non trouvée');
        }

        $articles = $articleRepository->findByCategory($category->getId());
        $categories = $categoryRepository->findAll();

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }
}

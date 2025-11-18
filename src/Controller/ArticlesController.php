<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function index(
        Request $request,
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository
    ): Response {
        $categorySlug = $request->query->get('category');
        $year = $request->query->get('year');
        $month = $request->query->get('month');

        // Récupérer tous les articles publiés
        $queryBuilder = $articleRepository->createQueryBuilder('a')
            ->where('a.isPublished = :published')
            ->setParameter('published', true)
            ->orderBy('a.createdAt', 'DESC');

        // Filtrer par catégorie
        if ($categorySlug) {
            $queryBuilder->innerJoin('a.categories', 'c')
                ->andWhere('c.slug = :categorySlug')
                ->setParameter('categorySlug', $categorySlug);
        }

        // Filtrer par année et mois avec STRFTIME (compatible SQLite)
        if ($year && $month) {
            // Créer les bornes de date pour le mois spécifique
            $startDate = new \DateTime("$year-$month-01");
            $endDate = clone $startDate;
            $endDate->modify('last day of this month')->setTime(23, 59, 59);

            $queryBuilder
                ->andWhere('a.createdAt >= :startDate')
                ->andWhere('a.createdAt <= :endDate')
                ->setParameter('startDate', $startDate)
                ->setParameter('endDate', $endDate);
        } elseif ($year) {
            // Filtrer uniquement par année
            $startDate = new \DateTime("$year-01-01");
            $endDate = new \DateTime("$year-12-31 23:59:59");

            $queryBuilder
                ->andWhere('a.createdAt >= :startDate')
                ->andWhere('a.createdAt <= :endDate')
                ->setParameter('startDate', $startDate)
                ->setParameter('endDate', $endDate);
        }

        $articles = $queryBuilder->getQuery()->getResult();

        // Récupérer toutes les catégories pour les filtres
        $categories = $categoryRepository->findAll();

        // Récupérer les années disponibles (en PHP plutôt qu'en SQL)
        $allArticles = $articleRepository->findBy(['isPublished' => true]);
        $years = [];
        foreach ($allArticles as $article) {
            $articleYear = $article->getCreatedAt()->format('Y');
            if (!in_array($articleYear, $years)) {
                $years[] = $articleYear;
            }
        }
        rsort($years); // Tri décroissant

        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
            'years' => $years,
            'selectedCategory' => $categorySlug,
            'selectedYear' => $year,
            'selectedMonth' => $month,
        ]);
    }
}

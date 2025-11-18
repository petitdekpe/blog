<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\PodcastRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository,
        PodcastRepository $podcastRepository
    ): Response {
        $featuredArticle = $articleRepository->findFeatured();
        $recentArticles = $articleRepository->findPublished(9);
        $categories = $categoryRepository->findAll();
        $recentPodcasts = $podcastRepository->createQueryBuilder('p')
            ->where('p.isPublished = :published')
            ->setParameter('published', true)
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();

        return $this->render('home/index.html.twig', [
            'featuredArticle' => $featuredArticle,
            'recentArticles' => $recentArticles,
            'recentPodcasts' => $recentPodcasts,
            'categories' => $categories,
        ]);
    }
}

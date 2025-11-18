<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PodcastRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PodcastController extends AbstractController
{
    #[Route('/podcast', name: 'app_podcast')]
    public function index(
        Request $request,
        PodcastRepository $podcastRepository,
        CategoryRepository $categoryRepository
    ): Response {
        $page = $request->query->getInt('page', 1);

        $queryBuilder = $podcastRepository->createQueryBuilder('p')
            ->where('p.isPublished = :published')
            ->setParameter('published', true)
            ->orderBy('p.createdAt', 'DESC');

        $adapter = new QueryAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(16);
        $pagerfanta->setCurrentPage($page);

        $categories = $categoryRepository->findAll();

        return $this->render('podcast/index.html.twig', [
            'episodes' => $pagerfanta,
            'categories' => $categories,
        ]);
    }
}

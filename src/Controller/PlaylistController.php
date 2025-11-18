<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlaylistController extends AbstractController
{
    #[Route('/playlists', name: 'app_playlists')]
    public function index(
        PlaylistRepository $playlistRepository,
        CategoryRepository $categoryRepository
    ): Response {
        $playlists = $playlistRepository->createQueryBuilder('p')
            ->where('p.isPublished = :published')
            ->setParameter('published', true)
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();

        $categories = $categoryRepository->findAll();

        return $this->render('playlist/index.html.twig', [
            'playlists' => $playlists,
            'categories' => $categories,
        ]);
    }
}

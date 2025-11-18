<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findPublished(int $limit = null): array
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.isPublished = :published')
            ->setParameter('published', true)
            ->orderBy('a.createdAt', 'DESC');

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }

    public function findFeatured(): ?Article
    {
        return $this->createQueryBuilder('a')
            ->where('a.isPublished = :published')
            ->andWhere('a.isFeatured = :featured')
            ->setParameter('published', true)
            ->setParameter('featured', true)
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByCategory(int $categoryId, int $limit = null): array
    {
        $qb = $this->createQueryBuilder('a')
            ->innerJoin('a.categories', 'c')
            ->where('a.isPublished = :published')
            ->andWhere('c.id = :category')
            ->setParameter('published', true)
            ->setParameter('category', $categoryId)
            ->orderBy('a.createdAt', 'DESC');

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }

    public function findBySlug(string $slug): ?Article
    {
        return $this->createQueryBuilder('a')
            ->where('a.slug = :slug')
            ->andWhere('a.isPublished = :published')
            ->setParameter('slug', $slug)
            ->setParameter('published', true)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

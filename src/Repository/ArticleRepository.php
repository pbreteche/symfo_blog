<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @param int $limit
     *
     * @return Article[]
     */
    public function findLatestPublished(int $limit=10): array
    {
        return $this->getEntityManager()->createQuery(
            'SELECT a, w FROM '.Article::class.' a'
            .' JOIN a.writtenBy w'
            .' WHERE a.publishedAt IS NOT NULL'
            .' AND a.publishedAt <= CURRENT_TIME()'
            .' ORDER BY a.publishedAt DESC'
        )->setMaxResults($limit)
        ->getResult();
    }

    public function findByTermInTitle(string $term)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.title LIKE :pattern')
            ->setParameter('pattern', '%'.$term.'%')
            ->getQuery()
            ->getResult();
    }
}

<?php

namespace App\Repository;

use App\Entity\QuestionResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QuestionResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionResult[]    findAll()
 * @method QuestionResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionResultRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QuestionResult::class);
    }

//    /**
//     * @return QuestionResult[] Returns an array of QuestionResult objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuestionResult
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

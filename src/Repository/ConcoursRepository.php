<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Concours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Concours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Concours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Concours[]    findAll()
 * @method Concours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Concours::class);
    }

    public function findSearch(SearchData $search)
    {
        return $this->createQueryBuilder('f')
            ->select('f', 'c', 't')
            ->leftJoin('f.cours', 'c')
            ->leftJoin('c.teachers', 't')
            ->andWhere('f.id = :id')
            ->setParameter('id', $search->formation->getId())
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}

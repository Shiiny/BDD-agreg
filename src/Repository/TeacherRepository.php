<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\BddSearch;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Teacher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Teacher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Teacher[]    findAll()
 * @method Teacher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Teacher::class);
    }

    /**
    * @return Teacher[] Returns an array of Teacher objects
    */

    public function findByLimite($value)
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.created_at', 'ASC')
            ->setMaxResults($value)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSearch(SearchData $search)
    {
        return $this->createQueryBuilder('t')
            ->select('t', 'c', 'd')
            ->leftJoin('t.cours', 'c')
            ->join('t.discipline', 'd')
            ->andWhere('t.id = :id')
            ->setParameter('id', $search->teacher->getId())
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

}

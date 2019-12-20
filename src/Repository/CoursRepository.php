<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Cours;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Cours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cours[]    findAll()
 * @method Cours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

    public function findSearch(SearchData $search): array
    {
        return $this->findAllExist()
            ->andWhere('c.title LIKE :search')
            ->setParameter('search', '%' .$search->cours. '%')
            ->getQuery()
            ->getResult();
    }

    public function findAllNoTeacher($param)
    {
        return $this->findAllExist()
            ->where('t.id IS NULL')
            ->orderBy('c.title', $param)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllByOrder($param)
    {
        return $this->findAllExist()
            ->orderBy('c.title', $param)
            ->getQuery()
            ->getResult()
            ;
    }

    private function findAllExist()
    {
        $query = $this->createQueryBuilder('c')
            ->select('c', 't', 'cc')
            ->leftJoin('c.teachers', 't')
            ->leftJoin('c.concours', 'cc')
            ;
        return $query;
    }
}

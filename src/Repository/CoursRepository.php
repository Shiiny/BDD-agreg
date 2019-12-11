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

    public function findByTeacher(Teacher $teacher)
    {
        return $this->createQueryBuilder('c')
            ->andWhere(':teacher MEMBER OF c.teachers')
            ->setParameter('teacher', $teacher->getId())
            ->getQuery()
            ->getResult()
            ;
    }

    public function findSearch(SearchData $search): array
    {
        return $this->createQueryBuilder('c')
            ->select('c', 't', 'd')
            ->leftJoin('c.teachers', 't')
            ->leftJoin('c.discipline', 'd')
            ->andWhere('c.title LIKE :search')
            ->setParameter('search', '%' .$search->cours. '%')
            ->getQuery()
            ->getResult();
    }
}

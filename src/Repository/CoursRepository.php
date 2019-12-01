<?php

namespace App\Repository;

use App\Entity\BddSearch;
use App\Entity\Cours;
use App\Entity\Formation;
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

    /**
     * @param Formation $formation
     * @return mixed
     */
    public function findAllByFormation(Formation $formation)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.formations', 'f')
            ->addSelect('f')
            ->andWhere('f.id = :id')
            ->setParameter('id', $formation->getId())
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param BddSearch $search
     */
    public function findByTitle(BddSearch $search): array
    {
        return $this->createQueryBuilder('c')
                ->where('c.title LIKE :search')
                ->setParameter('search', '%' .$search->getCours(). '%')
                ->getQuery()
                ->getResult();
    }


    // /**
    //  * @return Cours[] Returns an array of Cours objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cours
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

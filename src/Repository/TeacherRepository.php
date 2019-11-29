<?php

namespace App\Repository;

use App\Entity\BddSearch;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Query;
use phpDocumentor\Reflection\Types\Mixed_;

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

    /*
    public function findOneBySomeField($value): ?Teacher
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param BddSearch $search
     */
    public function findByParam(BddSearch $search)
    {

        $sql = 't.firstname LIKE :search 
                OR t.lastname LIKE :search';

        $query = $this->createQueryBuilder('t');

        if ($search->getTeacher()) {
                $query = $query->where($sql)
                    ->setParameter('search', '%' .$search->getTeacher(). '%');
        }


        return $query->getQuery()->getSingleResult();
    }
}

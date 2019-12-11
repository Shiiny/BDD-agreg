<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Formation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Formation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formation[]    findAll()
 * @method Formation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formation::class);
    }

    /**
     * @param SearchData $search
     * @return Formation
     */
    public function findSearch(SearchData $search)
    {
        return $this->createQueryBuilder('f')
            ->select('f', 'c', 't')
            ->leftJoin('f.Courses', 'c')
            ->leftJoin('c.teachers', 't')
            ->andWhere('f.id = :id')
            ->setParameter('id', $search->formation->getId())
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}

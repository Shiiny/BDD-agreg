<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Concours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Concours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Concours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Concours[]    findAll()
 * @method Concours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcoursRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Concours::class);
        $this->paginator = $paginator;
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

    /**
     * @param SearchData $search
     * @return PaginationInterface
     */
    public function findAllConcours(SearchData $search): PaginationInterface
    {
        $query = $this->createQueryBuilder('f')
            ->select('f', 'c', 't')
            ->leftJoin('f.cours', 'c')
            ->leftJoin('c.teachers', 't')
            ->getQuery();

        return $this->paginator->paginate(
          $query,
          $search->page,
          15
        );
    }
}

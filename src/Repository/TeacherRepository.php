<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Teacher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Teacher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Teacher[]    findAll()
 * @method Teacher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Teacher::class);
        $this->paginator = $paginator;
    }


    public function findByLimite($value)
    {
        return $this->createQueryBuilder('t')
            ->select('t', 'd')
            ->leftJoin('t.discipline', 'd')
            ->orderBy('t.created_at', 'DESC')
            ->setMaxResults($value)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSearch(SearchData $search)
    {
        return $this->createQueryBuilder('t')
            ->select('t', 'c', 'd', 'cc')
            ->leftJoin('t.cours', 'c')
            ->leftJoin('c.concours', 'cc')
            ->leftJoin('t.discipline', 'd')
            ->andWhere('t.id = :id')
            ->setParameter('id', $search->teacher->getId())
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @param SearchData $search
     * @return PaginationInterface
     */
    public function findAllTeacher(SearchData $search): PaginationInterface
    {
        $query = $this->createQueryBuilder('t')
            ->select('t', 'c', 'd', 'cc')
            ->leftJoin('t.cours', 'c')
            ->leftJoin('c.concours', 'cc')
            ->leftJoin('t.discipline', 'd')
            ->getQuery();

        return $this->paginator->paginate(
            $query,
            $search->page,
            15
        );
    }

    /**
     * @param SearchData $search
     * @return PaginationInterface
     */
    public function findSearchTeacher(SearchData $search): PaginationInterface
    {
        $query = $this->createQueryBuilder('t')
            ->select('t', 'c', 'd', 'cc')
            ->leftJoin('t.cours', 'c')
            ->leftJoin('c.concours', 'cc')
            ->leftJoin('t.discipline', 'd')
            ->andWhere('t.lastname LIKE :search OR t.firstname LIKE :search')
            ->setParameter('search', '%' .$search->teacher. '%')
            ->getQuery();

        return $this->paginator->paginate(
            $query,
            $search->page,
            15
        );
    }

}

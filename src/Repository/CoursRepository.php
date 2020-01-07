<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Cours;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Cours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cours[]    findAll()
 * @method Cours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Cours::class);
        $this->paginator = $paginator;
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

    /**
     * @param SearchData $search
     * @return PaginationInterface
     */
    public function findAllCourses(SearchData $search): PaginationInterface
    {
        $query = $this->findAllExist()
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
    public function findAllSearch(SearchData $search): PaginationInterface
    {
        $query = $this->findAllExist()
            ->andWhere('c.title LIKE :search')
            ->setParameter('search', '%' .$search->cours. '%')
            ->getQuery();

        return $this->paginator->paginate(
            $query,
            $search->page,
            15
        );
    }

    private function findAllExist()
    {
        return $this->createQueryBuilder('c')
            ->select('c', 't', 'd', 'cc')
            ->leftJoin('c.teachers', 't')
            ->leftJoin('c.concours', 'cc')
            ->join('c.discipline', 'd')
            ;
    }
}

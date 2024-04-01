<?php

namespace App\Repository;

use App\Entity\Postjob;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;


/**
 * @extends ServiceEntityRepository<Postjob>
 *
 * @method Postjob|null find($id, $lockMode = null, $lockVersion = null)
 * @method Postjob|null findOneBy(array $criteria, array $orderBy = null)
 * @method Postjob[]    findAll()
 * @method Postjob[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostjobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Postjob::class);
    }

    //  /**
    //  * @throws ORMException
    //  * @throws OptimisticLockException
    //  */    
    // public function findPaginated(int $currentPage = 1, int $limit = 2)
    // {
    //     $query = $this->createQueryBuilder('e')
    //         ->orderBy('e.id', 'ASC')
    //         ->getQuery()
    //         ->setFirstResult(($currentPage - 1) * $limit)
    //         ->setMaxResults($limit);

    //     return new Paginator($query, true);
    // }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Postjob $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Postjob $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Postjob[] Returns an array of Postjob objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Postjob
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findpostjob(int $val): array
    {
       

        $query = $this->createQueryBuilder('p')
        ->where("p.user_id = $val")
        ->getQuery();
        return $query->getResult();
      
    }

     /**
     * @return Answer[] Returns an array of Answer objects
     */
    public function findMostPopular(string $search = null): array
    {
        $queryBuilder = $this->createQueryBuilder('p')
        ->where("p.id IS NOT NULL");
        //->getQuery();
        // if ($search) {
        //     $queryBuilder->andWhere('answer.content LIKE :searchTerm')
        //         ->setParameter('searchTerm', '%'.$search.'%');
        // }
        return $queryBuilder
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}

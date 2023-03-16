<?php

namespace App\Repository;

use App\Entity\Response;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Response>
 *
 * @method Response|null find($id, $lockMode = null, $lockVersion = null)
 * @method Response|null findOneBy(array $criteria, array $orderBy = null)
 * @method Response[]    findAll()
 * @method Response[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Response::class);
    }

    public function save(Response $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Response $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // return an array of the response associated of the survey is active
    public function findResponseById($id): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.survey = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    // return an Response object associated of the name 
    public function findIdResponseOfName($name): Response
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.textResponse = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return Response[] Returns an array of Response objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Response
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

<?php

namespace App\Repository;

use App\Entity\Ticketing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ticketing>
 *
 * @method Ticketing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticketing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticketing[]    findAll()
 * @method Ticketing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticketing::class);
    }

    public function save(Ticketing $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ticketing $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Ticketing[] Returns an array of Ticketing objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Ticketing
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     * @return Ticketing[] Returns an array of Ticketing objects
     */
    public function findByType($type): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.type = :val')
            ->setParameter('val', $type)
            ->getQuery()
            ->getResult();
    }

    public function findByPermanent(): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere("t.type = 'permanente'")
            ->getQuery()
            ->getResult();
    }

    public function findByLimited(): array
    {
        return $this->createQueryBuilder('t')
            ->Where("t.type = 'limitée'")
            ->andWhere("t.orderNumber BETWEEN 1 AND 10")
            ->orderBy('t.orderNumber', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
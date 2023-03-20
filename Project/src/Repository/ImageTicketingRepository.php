<?php

namespace App\Repository;

use App\Entity\ImageTicketing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImageTicketing>
 *
 * @method ImageTicketing|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageTicketing|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageTicketing[]    findAll()
 * @method ImageTicketing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageTicketingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageTicketing::class);
    }

    public function save(ImageTicketing $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ImageTicketing $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // return an array associated of the image associated at the ticketing
    public function findImageTicketing(int $id): array
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.ticketing = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return ImageTicketing[] Returns an array of ImageTicketing objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ImageTicketing
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
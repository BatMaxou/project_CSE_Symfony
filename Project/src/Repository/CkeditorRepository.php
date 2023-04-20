<?php

namespace App\Repository;

use App\Entity\Ckeditor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ckeditor>
 *
 * @method Ckeditor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ckeditor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ckeditor[]    findAll()
 * @method Ckeditor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CkeditorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ckeditor::class);
    }

    public function save(Ckeditor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ckeditor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Ckeditor[] Returns an array of Ckeditor objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Ckeditor
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     * @return Ckeditor[] Returns an array of Ckeditor objects
     */
    public function findByPage($page): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.pageName = :val')
            ->setParameter('val', $page)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByZone($page, $zone): ?CKEditor
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.pageName = :page')
            ->andWhere('c.zone = :zone')
            ->setParameter('page', $page)
            ->setParameter('zone', $zone)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

<?php

namespace App\Repository;

use App\Entity\UserResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserResponse>
 *
 * @method UserResponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserResponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserResponse[]    findAll()
 * @method UserResponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserResponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserResponse::class);
    }

    public function save(UserResponse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserResponse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return UserResponse[] Returns an array of UserResponse objects
     */
    public function findUserResponsesByResponseId($id): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.response = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return UserResponse[] Returns an array of UserResponse objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?UserResponse
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

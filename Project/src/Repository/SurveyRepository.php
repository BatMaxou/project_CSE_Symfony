<?php

namespace App\Repository;

use App\Entity\Survey;
use App\Entity\Response;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Survey>
 *
 * @method Survey|null find($id, $lockMode = null, $lockVersion = null)
 * @method Survey|null findOneBy(array $criteria, array $orderBy = null)
 * @method Survey[]    findAll()
 * @method Survey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SurveyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Survey::class);
    }

    public function save(Survey $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Survey $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSurveyById(int $id): ?Survey
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return Survey[] Returns an array of Survey objects
     */
    public function findAllByDescAndActive(): array
    {
        return $this->createQueryBuilder('s')
            ->addOrderBy('s.isActive', 'DESC')
            ->addOrderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // return an Survey object associated of the survey active
    public function findActiveSurvey(): ?Survey
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.isActive = :active')
            ->setParameter('active', 1)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return Response[] Returns an array of Response objects
     */
    // retourne le nombre total de réponse associé à une question associé à un survey
    public function totalResponsesFor4LastSurveys(): array
    {
        $qb = $this->createQueryBuilder('survey');

        $qb->select('survey.question', 'COUNT(user_response.id) AS responses')
            ->innerJoin('App\Entity\Response', 'response', 'WITH', 'response.survey = survey.id')
            ->innerJoin('App\Entity\UserResponse', 'user_response', 'WITH', 'user_response.response = response.id')
            ->groupBy('survey.question')
            ->orderBy('responses', 'DESC')
            ->setMaxResults(4);

        return $qb->getQuery()->getResult();
    }


    //    /**
    //     * @return Survey[] Returns an array of Survey objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Survey
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

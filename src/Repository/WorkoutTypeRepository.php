<?php

namespace App\Repository;

use App\Entity\WorkoutType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkoutType>
 *
 * @method WorkoutType|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkoutType|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkoutType[]    findAll()
 * @method WorkoutType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkoutTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkoutType::class);
    }

    public function add(WorkoutType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WorkoutType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function update(WorkoutType $entity): void
    {
        $this->getEntityManager()->persist($entity);
        
        $this->getEntityManager()->flush();
    }

//    /**
//     * @return WorkoutType[] Returns an array of WorkoutType objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WorkoutType
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\Localite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineExtensions\Query\Mysql\Year;

/**
 * @extends ServiceEntityRepository<Localite>
 *
 * @method Localite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Localite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Localite[]    findAll()
 * @method Localite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocaliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Localite::class);
    }

    public function add(Localite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Localite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findLocalite($value): array
    {
          $conn = $this->getEntityManager()->getConnection();
            $sql = '
                SELECT localite.id,localite FROM code_postal c
                INNER JOIN localite on c.localite_id = localite.id
                WHERE c.id = '.$value.'
                ORDER BY localite ASC ';
                $stmt = $conn->prepare($sql);
                $resultSet = $stmt->executeQuery();

                // returns an array of arrays (i.e. a raw data set)
                return $resultSet->fetchAllAssociative();
        }


    public function findAllLocalite(){
        return $this->createQueryBuilder('a')
            ->orderBy('a.localite', 'ASC')
            ->distinct(True)
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return Localite[] Returns an array of Localite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Localite
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

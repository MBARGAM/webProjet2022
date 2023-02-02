<?php

namespace App\Repository;

use App\Entity\Prestataire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Prestataire>
 *
 * @method Prestataire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prestataire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prestataire[]    findAll()
 * @method Prestataire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrestataireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prestataire::class);
    }

    public function add(Prestataire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Prestataire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findLastId()
    {
        return $this->createQueryBuilder('p')
            ->select('p.id')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findPrestataire($value): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
                SELECT p.id,p.nom, p.tel,p.numero_Tva as NoTVA ,p.bloque ,p.description,p.siteweb AS site,
                       utilisateur.email,utilisateur.adresse_no as No , utilisateur.adresse_rue AS rue , utilisateur.visible,utilisateur.inscript_conf as confirme,
                       commune.commune ,localite.localite , code_postal.cp FROM prestataire p
                INNER JOIN utilisateur  on p.id = utilisateur.prestataire_id
                INNER JOIN commune on utilisateur.commune_id = commune.id
                INNER JOIN localite on utilisateur.localite_id = localite.id
                INNER JOIN code_postal on utilisateur.cp_id = code_postal.id                                                         
                WHERE p.id = '.$value.'
                ORDER BY nom ASC ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }


//    /**
//     * @return Prestataire[] Returns an array of Prestataire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Prestataire
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

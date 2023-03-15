<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 *
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    public function add(Categorie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Categorie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findAllCategorie(){
        return $this->createQueryBuilder('a')
            ->orderBy('a.nom', 'ASC')
            ->Where('a.validation = 1')
            ->distinct(True)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findCategorieChoisie(){
        return $this->createQueryBuilder('a')
            ->Where('a.misEnAvant = 1')
            ->AndWhere('a.validation = 1')
            ->getQuery()
            ->getResult()
            ;
    }

    public function AllCategorie(){
        return $this->createQueryBuilder('a')
            ->orderBy('a.nom', 'ASC')
            ->distinct(True)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findCategorie($id){
        return $this->createQueryBuilder('a')
            ->select('a')
            ->distinct(True)
            ->where('a.id = :val')
            ->AndWhere('a.validation = 1')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult()
            ;
    }

    // requete pour trouver les categories d'un prestataire relation ManyToMany
    public function findCategoriePrestataire($value): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
                SELECT c.id, c.nom ,c.description,c.validation,c.mis_en_avant  FROM categorie c
                INNER JOIN categorie_prestataire   on c.id = categorie_prestataire.categorie_id
                INNER JOIN prestataire  on categorie_prestataire.prestataire_id =  prestataire.id                                                    
                WHERE prestataire.id = '.$value.' AND c.validation = 1
                ORDER BY c.nom DESC ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }



//    /**
//     * @return Categorie[] Returns an array of Categorie objects
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

//    public function findOneBySomeField($value): ?Categorie
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

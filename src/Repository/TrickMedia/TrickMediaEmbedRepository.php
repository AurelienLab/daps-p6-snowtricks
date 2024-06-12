<?php

namespace App\Repository\TrickMedia;

use App\Entity\TrickMedia\TrickMediaEmbed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrickMediaEmbed>
 *
 * @method TrickMediaEmbed|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrickMediaEmbed|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrickMediaEmbed[]    findAll()
 * @method TrickMediaEmbed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickMediaEmbedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrickMediaEmbed::class);
    }

//    /**
//     * @return TrickMediaEmbed[] Returns an array of TrickMediaEmbed objects
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

//    public function findOneBySomeField($value): ?TrickMediaEmbed
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

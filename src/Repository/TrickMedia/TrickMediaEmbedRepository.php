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


}

<?php

namespace App\Repository\TrickMedia;

use App\Entity\TrickMedia\TrickMedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrickMedia>
 *
 * @method TrickMedia|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrickMedia|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrickMedia[]    findAll()
 * @method TrickMedia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickMediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrickMedia::class);
    }
}

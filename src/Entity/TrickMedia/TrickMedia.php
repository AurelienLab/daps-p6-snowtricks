<?php

namespace App\Entity\TrickMedia;

use App\Entity\TimestampableInterface;
use App\Entity\Trait\Timestampable;
use App\Entity\Trick;
use App\Repository\TrickMedia\TrickMediaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrickMediaRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: 'media_type', type: 'string')]
#[ORM\DiscriminatorMap([
    'embed' => TrickMediaEmbed::class,
    'image' => TrickMediaImage::class,
])]
class TrickMedia implements TimestampableInterface
{

    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'medias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trick $trick = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): static
    {
        $this->trick = $trick;

        return $this;
    }
}

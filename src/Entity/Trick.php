<?php

namespace App\Entity;

use App\Entity\Trait\Timestampable;
use App\Repository\TrickRepository;
use Doctrine\Common\EventArgs;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[ORM\Entity(repositoryClass: TrickRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_SLUG', fields: ['slug'])]
#[UniqueEntity(fields: ['slug'], message: 'Un trick existe déjà avec ce nom')]
#[ORM\HasLifecycleCallbacks]
class Trick implements TimestampableInterface
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'tricks')]
    private ?User $author = null;

    #[ORM\ManyToOne(inversedBy: 'tricks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TrickCategory $trickCategory = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setSlug(string|EventArgs|null $slug): Trick
    {
        $slugger = new AsciiSlugger();

        $newSlug = $slug instanceof EventArgs ? $this->name : $slug;

        $this->slug = strtolower($slugger->slug($newSlug));

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getTrickCategory(): ?TrickCategory
    {
        return $this->trickCategory;
    }

    public function setTrickCategory(?TrickCategory $trickCategory): static
    {
        $this->trickCategory = $trickCategory;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Entity\Trait\Timestampable;
use App\Entity\TrickMedia\TrickMedia;
use App\Entity\TrickMedia\TrickMediaImage;
use App\Repository\TrickRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, TrickMedia>
     */
    #[ORM\OneToMany(targetEntity: TrickMedia::class, mappedBy: 'trick', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $medias;

    #[ORM\OneToMany(targetEntity: TrickMediaImage::class, mappedBy: 'trick', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $mediaImages;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $featuredPicture = null;

    public function __construct()
    {
        $this->medias = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, TrickMedia>
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(TrickMedia $media): static
    {
        if (!$this->medias->contains($media)) {
            $this->medias->add($media);
            $media->setTrick($this);
        }

        return $this;
    }

    public function removeMedia(TrickMedia $media): static
    {
        if ($this->medias->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getTrick() === $this) {
                $media->setTrick(null);
            }
        }

        return $this;
    }

    public function setMedias(Collection $medias): Trick
    {
        // Remove all medias from current collection
        foreach ($this->medias as $currentMedia) {
            $this->medias->removeElement($currentMedia);
        }

        // Add each new media
        foreach ($medias as $media) {
            $media->setTrick($this);
            $this->medias->add($media);
        }

        return $this;
    }


    public function getFeaturedPicture(): ?string
    {
        return $this->featuredPicture;
    }

    public function setFeaturedPicture(?string $featuredPicture): static
    {
        $this->featuredPicture = $featuredPicture;

        return $this;
    }

    public function getMediaImages(): Collection
    {
        return $this->mediaImages;
    }
}

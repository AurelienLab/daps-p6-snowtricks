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
#[UniqueEntity(fields: ['name'], message: 'snowtricks.entity.trick.unique')]
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $featuredPicture = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'trick', orphanRemoval: true)]
    private Collection $comments;


    public function __construct()
    {
        $this->medias = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }


    /**
     * @param string|EventArgs|null $slug
     * @return $this
     */
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setSlug(string|EventArgs|null $slug): Trick
    {
        $slugger = new AsciiSlugger();

        $newSlug = $slug instanceof EventArgs ? $this->name : $slug;

        $this->slug = strtolower($slugger->slug($newSlug));

        return $this;
    }


    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }


    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }


    /**
     * @param User|null $author
     * @return $this
     */
    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }


    /**
     * @return TrickCategory|null
     */
    public function getTrickCategory(): ?TrickCategory
    {
        return $this->trickCategory;
    }


    /**
     * @param TrickCategory|null $trickCategory
     * @return $this
     */
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


    /**
     * @param TrickMedia $media
     * @return $this
     */
    public function addMedia(TrickMedia $media): static
    {
        if (!$this->medias->contains($media)) {
            $this->medias->add($media);
            $media->setTrick($this);
        }

        return $this;
    }


    /**
     * @param TrickMedia $media
     * @return $this
     */
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


    /**
     * @param Collection $medias
     * @return $this
     */
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


    /**
     * @return string|null
     */
    public function getFeaturedPicture(): ?string
    {
        return $this->featuredPicture;
    }


    /**
     * @param string|null $featuredPicture
     * @return $this
     */
    public function setFeaturedPicture(?string $featuredPicture): static
    {
        $this->featuredPicture = $featuredPicture;

        return $this;
    }


    /**
     * @return Collection
     */
    public function getMediaImages(): Collection
    {
        return $this->medias->filter(
            function (TrickMedia $mediaImage) {
                return $mediaImage instanceof TrickMediaImage;
            }
        );
    }


    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }


    /**
     * @param Comment $comment
     * @return $this
     */
    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setTrick($this);
        }

        return $this;
    }


    /**
     * @param Comment $comment
     * @return $this
     */
    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }


}

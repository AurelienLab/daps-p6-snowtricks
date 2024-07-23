<?php

namespace App\Entity;

use App\Entity\Trait\Timestampable;
use App\Repository\TrickCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\EventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[ORM\Entity(repositoryClass: TrickCategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class TrickCategory implements TimestampableInterface
{


    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @var Collection<int, Trick>
     */
    #[ORM\OneToMany(targetEntity: Trick::class, mappedBy: 'trickCategory')]
    private Collection $tricks;


    public function __construct()
    {
        $this->tricks = new ArrayCollection();
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
    public function setSlug(string|EventArgs|null $slug): TrickCategory
    {
        $slugger = new AsciiSlugger();

        $newSlug = $slug instanceof EventArgs ? $this->name : $slug;

        $this->slug = strtolower($slugger->slug($newSlug));

        return $this;
    }


    /**
     * @return Collection<int, Trick>
     */
    public function getTricks(): Collection
    {
        return $this->tricks;
    }


    /**
     * @param Trick $trick
     * @return $this
     */
    public function addTrick(Trick $trick): static
    {
        if (!$this->tricks->contains($trick)) {
            $this->tricks->add($trick);
            $trick->setTrickCategory($this);
        }

        return $this;
    }


    /**
     * @param Trick $trick
     * @return $this
     */
    public function removeTrick(Trick $trick): static
    {
        if ($this->tricks->removeElement($trick)) {
            // set the owning side to null (unless already changed)
            if ($trick->getTrickCategory() === $this) {
                $trick->setTrickCategory(null);
            }
        }

        return $this;
    }


}

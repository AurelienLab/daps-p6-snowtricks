<?php

namespace App\Entity;

use App\Entity\Trait\Timestampable;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface, TimestampableInterface
{


    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: 'snowtricks.form.email.not_blank')]
    #[Assert\Email(message: 'snowtricks.form.email.valid')]
    private ?string $email = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'snowtricks.form.name.not_blank')]
    #[Assert\Length(min: 3)]
    private ?string $name = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string|null The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(nullable: true)]
    private ?string $profilePicture = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    /**
     * @var Collection<int, Trick>
     */
    #[ORM\OneToMany(targetEntity: Trick::class, mappedBy: 'author')]
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
    public function getEmail(): ?string
    {
        return $this->email;
    }


    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param string|null $name
     * @return $this
     */
    public function setName(?string $name): User
    {
        $this->name = $name;
        return $this;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }


    /**
     * @return list<string>
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        if (empty($this->roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }


    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }


    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }


    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }


    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    /**
     * @return string|null
     */
    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }


    /**
     * @param string|null $profilePicture
     * @return $this
     */
    public function setProfilePicture(?string $profilePicture): User
    {
        $this->profilePicture = $profilePicture;
        return $this;
    }


    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->isVerified;
    }


    /**
     * @param bool $isVerified
     * @return $this
     */
    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

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
            $trick->setAuthor($this);
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
            if ($trick->getAuthor() === $this) {
                $trick->setAuthor(null);
            }
        }

        return $this;
    }


}

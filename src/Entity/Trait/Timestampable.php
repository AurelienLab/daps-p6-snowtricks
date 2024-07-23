<?php

namespace App\Entity\Trait;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\TrickCategory;
use App\Entity\TrickMedia\TrickMedia;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait Timestampable
{


    #[ORM\Column(nullable: false)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: false)]
    private DateTimeImmutable $updatedAt;


    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }


    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }


    /**
     * @return DateTimeImmutable
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }


    /**
     * @param DateTimeImmutable $updatedAt
     * @return Timestampable|Comment|Trick|TrickCategory|TrickMedia|User
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }


    /**
     * Automatically set createdAt value at persist
     * @return void
     */
    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->setCreatedAt(new DateTimeImmutable());
    }


    /**
     * Automatically set updatedAt value at persist and update
     * @return void
     */
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->setUpdatedAt(new DateTimeImmutable());
    }


}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

interface TimestampableInterface
{

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable;

    /**
     * @param \DateTimeImmutable $createdAt
     * @return self
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): self;

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable;

    /**
     * @param \DateTimeImmutable $updatedAt
     * @return self
     */
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self;


}

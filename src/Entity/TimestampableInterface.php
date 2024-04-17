<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

interface TimestampableInterface
{

    public function getCreatedAt(): \DateTimeImmutable;

    public function setCreatedAt(\DateTimeImmutable $createdAt): self;

    public function getUpdatedAt(): \DateTimeImmutable;

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self;


}

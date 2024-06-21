<?php

namespace App\Entity\TrickMedia;

use App\Form\TrickMedia\TrickMediaImageType;
use App\Repository\TrickMedia\TrickMediaImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TrickMediaImageRepository::class)]
class TrickMediaImage extends TrickMedia implements TrickMediaInterface
{
    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $alt = null;

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): static
    {
        $this->alt = $alt;

        return $this;
    }

    public function getTemplate(): string
    {
        return '_partials/trick-media/image.html.twig';
    }
}

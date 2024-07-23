<?php

namespace App\Entity\TrickMedia;

use App\Repository\TrickMedia\TrickMediaImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrickMediaImageRepository::class)]
class TrickMediaImage extends TrickMedia implements TrickMediaInterface
{
    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $alt = null;


    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }


    /**
     * @param string $image
     * @return $this
     */
    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getAlt(): ?string
    {
        return $this->alt;
    }


    /**
     * @param string|null $alt
     * @return $this
     */
    public function setAlt(?string $alt): static
    {
        $this->alt = $alt;

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function getTemplate(): string
    {
        return '_partials/trick-media/image.html.twig';
    }


}

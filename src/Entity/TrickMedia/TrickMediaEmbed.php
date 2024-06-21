<?php

namespace App\Entity\TrickMedia;

use App\Form\TrickMedia\TrickMediaEmbedType;
use App\Repository\TrickMedia\TrickMediaEmbedRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrickMediaEmbedRepository::class)]
class TrickMediaEmbed extends TrickMedia implements TrickMediaInterface
{
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getTemplate(): string
    {
        return '_partials/trick-media/embed.html.twig';
    }
}

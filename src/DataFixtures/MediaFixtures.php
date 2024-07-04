<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use App\Entity\TrickMedia\TrickMediaEmbed;
use App\Entity\TrickMedia\TrickMediaImage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MediaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $mediaImages = [
            [
                'reference' => 'backflip',
                'image' => 'backflip.jpg',
            ],
            [
                'reference' => 'mutegrab',
                'image' => 'mute-grab.jpg',
            ],
            [
                'reference' => 'stalefish',
                'image' => 'stalefish.jpg',
            ],
        ];

        $mediaEmbeds = [
            [
                'reference' => 'shifty',
                'content' => '<iframe src="https://www.youtube.com/embed/MdhS9tu7TWg?si=DYv1x0hsJewmMbpj" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen width="160" height="90"></iframe>'
            ],
            [
                'reference' => 'frontside360',
                'content' => '<iframe src="https://www.youtube.com/embed/SLncsNaU6es?si=sWSCUEX5gUfP08Ve" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen width="160" height="90"></iframe>'
            ],

        ];

        foreach ($mediaImages as $mediaImageData) {
            $mediaImage = new TrickMediaImage();
            $mediaImage->setImage($mediaImageData['image']);

            $this->getReference($mediaImageData['reference'], Trick::class)->addMedia($mediaImage);
        }

        foreach ($mediaEmbeds as $mediaEmbedData) {
            $mediaEmbed = new TrickMediaEmbed();
            $mediaEmbed->setContent($mediaEmbedData['content']);

            $this->getReference($mediaEmbedData['reference'], Trick::class)->addMedia($mediaEmbed);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TrickFixtures::class,
        ];
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $comments = [
            [
                'reference' => 'backflip',
                'author' => 'user',
                'comment' => 'J\'ai enfin réussi mon premier backflip ! La sensation est incroyable, je le recommande à tous ceux qui veulent impressionner leurs amis.'
            ],
            [
                'reference' => 'backflip',
                'author' => 'admin',
                'comment' => 'N\'oubliez pas de bien fléchir les genoux et de garder le regard fixé sur un point pour réussir ce trick en toute sécurité.'
            ],
            [
                'reference' => 'frontside360',
                'author' => 'user',
                'comment' => 'Le frontside 360 est parfait pour ajouter du style à mes sauts, mais la rotation est plus difficile que je ne le pensais.'
            ],
            [
                'reference' => 'nosegrab',
                'author' => 'admin',
                'comment' => 'Pour un nose grab réussi, assurez-vous de bien plier les genoux et de tendre la main avant pour attraper le bout de votre planche.'
            ],
            [
                'reference' => 'nosegrab',
                'author' => 'user',
                'comment' => 'Le nose grab est maintenant mon trick préféré. Ça donne vraiment une touche personnelle à mes sauts.'
            ],
            [
                'reference' => 'methodair',
                'author' => 'admin',
                'comment' => 'Le method air est un excellent moyen de montrer votre technique et votre attitude. N\'oubliez pas de bien fléchir les genoux et d\'attraper le talon de votre planche.'
            ],
            [
                'reference' => 'indygrab',
                'author' => 'user',
                'comment' => 'J\'adore l\'indy grab, c\'est un classique qui ne déçoit jamais. La vue pendant le saut est tout simplement époustouflante.'
            ],
            [
                'reference' => 'shifty',
                'author' => 'admin',
                'comment' => 'Le shifty est parfait pour donner du mouvement à vos sauts. Assurez-vous de bien pivoter vos hanches et de garder l\'équilibre.'
            ],
            [
                'reference' => 'mutegrab',
                'author' => 'user',
                'comment' => 'Le mute grab est un trick discret mais efficace. C\'est devenu mon nouveau favori.'
            ],
            [
                'reference' => 'chickensalad',
                'author' => 'admin',
                'comment' => 'Le chicken salad est un trick fun avec un nom qui donne faim. N\'oubliez pas de bien attraper le côté de votre planche derrière vos pieds.'
            ]
        ];

        foreach ($comments as $commentData) {
            $comment = new Comment();
            $comment
                ->setAuthor($this->getReference($commentData['author'], User::class))
                ->setTrick($this->getReference($commentData['reference'], Trick::class))
                ->setMessage($commentData['comment'])
            ;

            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TrickFixtures::class,
            UserFixtures::class,
        ];
    }
}

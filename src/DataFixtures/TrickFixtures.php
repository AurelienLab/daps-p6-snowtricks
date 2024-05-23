<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TrickFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tricks = [
            [
                'name' => 'Backflip',
                'description' => 'Imagine-toi faire un salto arrière avec ton snowboard, histoire de montrer à tout le monde qui est le boss des montagnes !' . PHP_EOL . PHP_EOL .
                    'Le backflip, c’est un peu comme si tu étais un super-héros qui virevolte dans les airs, sauf que tu restes bien stylé avec ta planche.' . PHP_EOL . PHP_EOL .
                    'Pour le réussir, prends de la vitesse, fléchis les genoux et lance-toi en arrière en donnant une impulsion. Garde ton regard fixé sur un point pour ne pas perdre l’équilibre, et laisse la gravité faire le reste. Tu verras, l’atterrissage sera presque aussi impressionnant que le saut !'
            ],
            [
                'name' => 'Frontside 360',
                'description' => 'Un petit tour de 360 degrés dans les airs, juste pour prouver que tu sais comment tourner la tête sans te perdre. C’est comme une pirouette, mais avec un snowboard aux pieds et beaucoup plus de style.' . PHP_EOL . PHP_EOL .
                    'Pour réaliser un frontside 360, commence par prendre de l’élan et fléchis légèrement les genoux. Utilise tes épaules pour initier la rotation en tournant ton corps vers l’avant. Reste compact et concentré, et prépare-toi à retrouver le sol avec grâce. Tu verras, tout le monde aura les yeux rivés sur toi !'
            ],
            [
                'name' => 'Nose Grab',
                'description' => 'Attrape l’avant de ta planche en plein saut, comme si tu voulais lui faire un câlin. Adorable, non ? Le nose grab, c’est un moyen parfait de montrer que tu es aussi agile qu’un chat des neiges.' . PHP_EOL . PHP_EOL .
                    'Pour le faire, prends de la vitesse et saute bien haut. Plie tes genoux et tends la main avant pour attraper le bout de ta planche. Maintiens la prise aussi longtemps que possible avant de relâcher et de te préparer pour l’atterrissage. Ce trick est idéal pour ajouter une touche personnelle à tes sauts !'
            ],
            [
                'name' => 'Tail Grab',
                'description' => 'Tiens-toi au bout de ta planche pendant que tu voles, juste pour montrer que même en l’air, tu sais garder le contrôle. Le tail grab, c’est l’art de maîtriser le chaos avec style.' . PHP_EOL . PHP_EOL .
                    'Pour y arriver, prends de l’élan et saute en fléchissant les genoux. Pendant que tu es en l’air, tends la main arrière pour attraper le bout de ta planche. Garde bien ton équilibre et profite de la vue avant de te préparer pour l’atterrissage. Rien de tel pour épater la galerie !'
            ],
            [
                'name' => 'Method Air',
                'description' => 'Fléchis les genoux, tends une main derrière et fais semblant d’être une rock star en plein concert. Voilà, c’est ça le style. Le method air, c’est le combo parfait de technique et d’attitude.' . PHP_EOL . PHP_EOL .
                    'Pour le réaliser, prends de la vitesse et saute bien haut. Fléchis les genoux, attrape le talon de ta planche avec la main arrière et étire l’autre main derrière toi. Garde une posture bien ouverte et prépare-toi à atterrir avec style. Ce trick est parfait pour montrer que tu as du flair !'
            ],
            [
                'name' => 'Indy Grab',
                'description' => 'Saisis le côté de ta planche entre tes pieds et profite de la vue pendant que tu planes comme une étoile filante. L’Indy grab, c’est un classique qui ne déçoit jamais.' . PHP_EOL . PHP_EOL .
                    'Pour le faire, prends de l’élan et saute en fléchissant les genoux. Avec la main arrière, attrape le côté de ta planche entre tes pieds. Maintiens la prise aussi longtemps que possible et garde ton regard droit devant. L’atterrissage doit être fluide et contrôlé pour que tout le monde puisse admirer ta maîtrise.'
            ],
            [
                'name' => 'Stalefish',
                'description' => 'Attrape le talon de ta planche avec la main opposée, comme si tu essayais de pêcher un poisson stellaire en plein vol. Le stalefish, c’est un nom rigolo pour un trick très stylé.' . PHP_EOL . PHP_EOL .
                    'Pour y arriver, prends de la vitesse et saute en fléchissant les genoux. Avec la main arrière, attrape le côté de ta planche entre tes pieds. Maintiens la prise aussi longtemps que possible et garde ton regard droit devant. L’atterrissage doit être fluide et contrôlé pour que tout le monde puisse admirer ta maîtrise.'
            ],
            [
                'name' => 'Shifty',
                'description' => 'Fais pivoter ta planche d’un côté à l’autre dans les airs, histoire de montrer que tu sais te faufiler comme personne. Le shifty, c’est l’art de donner du mouvement à ton saut.' . PHP_EOL . PHP_EOL .
                    'Pour le réaliser, prends de l’élan et saute bien haut. Pendant que tu es en l’air, fais pivoter tes hanches et ta planche d’un côté, puis de l’autre. Reste bien concentré pour garder ton équilibre et prépare-toi à atterrir en douceur. Ce trick est idéal pour ajouter une touche dynamique à tes sauts.'
            ],
            [
                'name' => 'Mute Grab',
                'description' => 'Attrape ta planche entre les pieds avec la main avant, tout en restant cool et silencieux, comme un ninja des neiges. Le mute grab, c’est l’essence même du style discret mais efficace.' . PHP_EOL . PHP_EOL .
                    'Pour le faire, prends de l’élan et saute en fléchissant les genoux. Avec la main avant, attrape le côté de ta planche entre tes pieds. Garde la prise aussi longtemps que possible et reste concentré sur ton équilibre. L’atterrissage doit être fluide et précis pour que personne ne sache à quel point c’était difficile !'
            ],
            [
                'name' => 'Chicken Salad',
                'description' => 'Prends ta planche derrière tes pieds avec la main avant, et fais comme si tu préparais une salade de poulet en plein air. Le chicken salad, c’est un trick fun avec un nom qui donne faim.' . PHP_EOL . PHP_EOL .
                    'Pour y arriver, prends de la vitesse et saute en fléchissant les genoux. Avec la main avant, attrape le côté de ta planche derrière tes pieds. Garde bien ton équilibre et profite de la sensation de voler tout en préparant ta "salade". Prépare-toi à atterrir avec style pour couronner le tout !'
            ],
        ];


        foreach ($tricks as $trickData) {
            $trick = new Trick();
            $trick->setName($trickData['name']);
            $trick->setDescription($trickData['description']);
            $manager->persist($trick);
        }

        $manager->flush();
    }
}

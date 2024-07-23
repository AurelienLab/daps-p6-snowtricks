<?php

namespace App\DataFixtures;

use App\Entity\TrickCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TrickCategoryFixtures extends Fixture
{


    const CATEGORY_GRAB = 'grab';
    const CATEGORY_SPIN = 'spin';
    const CATEGORY_FLIP = 'flip';


    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $categories = [];

        $categories[self::CATEGORY_GRAB] = 'Grab';
        $categories[self::CATEGORY_SPIN] = 'Spin';
        $categories[self::CATEGORY_FLIP] = 'Flip';


        foreach ($categories as $reference => $category) {
            $trickCategory = new TrickCategory();
            $trickCategory->setName($category);

            $manager->persist($trickCategory);
            $this->addReference($reference, $trickCategory);
        }

        $manager->flush();
    }


}

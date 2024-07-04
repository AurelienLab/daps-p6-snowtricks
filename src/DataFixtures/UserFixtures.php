<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        // Admin
        $admin = new User();
        $password = $this->passwordHasher->hashPassword($admin, 'STadmin2k24#');
        $admin
            ->setRoles(['ROLE_ADMIN'])
            ->setEmail('admin@snowtricks.com')
            ->setName('Administrateur')
            ->setPassword($password)
        ;
        $manager->persist($admin);


        // User
        $user = new User();
        $password = $this->passwordHasher->hashPassword($user, 'STuser2k24#');
        $user
            ->setRoles(['ROLE_USER'])
            ->setEmail('user@snowtricks.com')
            ->setName('Utilisateur')
            ->setPassword($password)
        ;
        $manager->persist($user);

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $pwd = '$2y$13$vutypgho4k1jIlDm94YL1.JDdCSqzZv8HqtWtQC5BlMOK6I.HfUc6';//test
        $pwd_admin = '$2y$13$W3hdYh2cwK6dW1bLefMA9ut5a12gPBU54AkyCsbW71PUa7m/9VHhS';//jardinerie02

        $user = (new User())
            ->setEmail('pi.boitelle@gmail.com')
            ->setRoles(['ROLE_USER'])
            ->setLastname('Boitelle')
            ->setFirstname('Pierre')
            ->setIsValid(true)
            ->setPassword($pwd)
        ;
        $manager->persist($user);

        $user = (new User())
            ->setEmail('pierre.boitelle@gmail.com')
            ->setRoles(['ROLE_USER'])
            ->setLastname('Dan')
            ->setFirstname('Levy')
            ->setIsValid(false)
            ->setPassword($pwd)
        ;
        $manager->persist($user);

        $admin = (new User())
            ->setEmail('admin@admin.fr')
            ->setLastname('admin')
            ->setFirstname('admin')
            ->setRoles(['ROLE_ADMIN'])
            ->setIsValid(true)
            ->setPassword($pwd_admin)
        ;
        $manager->persist($admin);

        $bloger = (new User())
            ->setEmail('blog@blog.fr')
            ->setLastname('Victor')
            ->setFirstname('Valee')
            ->setRoles(['ROLE_BLOGER'])
            ->setIsValid(true)
            ->setPassword($pwd)
        ;
        $manager->persist($bloger);

        $bloger = (new User())
            ->setEmail('blog2@blog2.fr')
            ->setLastname('Ulysse')
            ->setFirstname('MF')
            ->setRoles(['ROLE_BLOGER'])
            ->setIsValid(true)
            ->setPassword($pwd)
        ;
        $manager->persist($bloger);

        $manager->flush();
    }
}

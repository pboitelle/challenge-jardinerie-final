<?php

namespace App\DataFixtures;

use App\Entity\Hackathon;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $pwd = '$2y$13$vutypgho4k1jIlDm94YL1.JDdCSqzZv8HqtWtQC5BlMOK6I.HfUc6';

        $user = (new User())
            ->setEmail('user@user.fr')
            ->setRoles(['ROLE_USER'])
            ->setPassword($pwd)
        ;
        $manager->persist($user);

        $admin = (new User())
            ->setEmail('admin@user.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($pwd)
        ;
        $manager->persist($admin);

        $customer = (new User())
            ->setEmail('customer@user.fr')
            ->setRoles(['ROLE_CUSTOMER'])
            ->setPassword($pwd)
        ;
        $manager->persist($customer);

        $coach = (new User())
            ->setEmail('coach@user.fr')
            ->setRoles(['ROLE_COACH'])
            ->setPassword($pwd)
        ;
        $manager->persist($coach);

        $manager->flush();
    }
}

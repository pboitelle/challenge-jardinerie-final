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
        $pwd = '$2y$13$vutypgho4k1jIlDm94YL1.JDdCSqzZv8HqtWtQC5BlMOK6I.HfUc6';

        $user = (new User())
            ->setEmail('user@user.fr')
            ->setRoles(['ROLE_USER'])
            ->setLastname('Boitelle')
            ->setFirstname('Pierre')
            ->setPassword($pwd)
        ;
        $manager->persist($user);

        $admin = (new User())
            ->setEmail('admin@admin.fr')
            ->setLastname('admin')
            ->setFirstname('admin')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($pwd)
        ;
        $manager->persist($admin);

        $customer = (new User())
            ->setEmail('blog@blog.fr')
            ->setLastname('Victor')
            ->setFirstname('Valee')
            ->setRoles(['ROLE_BLOGER'])
            ->setPassword($pwd)
        ;
        $manager->persist($customer);

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Item;
use App\Entity\User;
use App\Entity\Market;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class MarketFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $items = $manager->getRepository(Item::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();


        for ($i = 0; $i < 20; $i++) {

            $market = new Market();
            $market->setUserId($faker->randomElement($users));
            $market->setItemId($faker->unique()->randomElement($items));
            $market->setPrix($faker->numberBetween(1, 50));

            $manager->persist($market);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ItemFixtures::class,
            UserFixtures::class,
        ];
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Hackathon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class HackathonFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i=0; $i<10; $i++) {
            $object = (new Hackathon())
                ->setName($faker->colorName)
                ->setClientName($faker->firstName)
                ->setStartDate($faker->dateTimeBetween('-1 years'))
            ;

            $object->setEndDate(new \DateTime($object->getStartDate()->format('Y-m-d') . ' +7 days'));

            $manager->persist($object);
        }

        $manager->flush();
    }
}

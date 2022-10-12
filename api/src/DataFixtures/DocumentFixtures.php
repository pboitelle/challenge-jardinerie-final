<?php

namespace App\DataFixtures;

use App\Entity\Document;
use App\Entity\Event;
use App\Entity\Hackathon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DocumentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $hackathons = $manager->getRepository(Hackathon::class)->findAll();

        for ($i=0; $i<30; $i++) {
            $object = (new Document())
                ->setName($faker->colorName)
                ->setFile($faker->paragraph)
                ->setHackathon($faker->randomElement($hackathons))
            ;

            $manager->persist($object);
        }

        $manager->flush();
    }


    public function getDependencies()
    {
        return [
          HackathonFixtures::class
        ];
    }
}

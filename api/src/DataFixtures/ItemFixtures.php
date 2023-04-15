<?php

namespace App\DataFixtures;

use App\Entity\Plante;
use App\Entity\Niveau;
use App\Entity\Item;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $plantes = $manager->getRepository(Plante::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();

        $niveaux = $manager->getRepository(Niveau::class)->findAll();


        $items_factice = [];
        for ($i = 1; $i <= 100; $i++) {
            if ($i <= 80) {
                $items_factice[] = 0;
            } elseif ($i <= 99) {
                $items_factice[] = 1;
            } else {
                $items_factice[] = 2;
            }
        }

        for ($i = 0; $i < 100; $i++) {

            $niveau_item = $items_factice[array_rand($items_factice, 1)];

            $item = new Item();
            $item->setIsPlanted(false);
            $item->setHasGrown(false);
            $item->setNiveau($niveaux[$niveau_item]);
            $item->setPlante($faker->randomElement($plantes));
            $item->setUserId($faker->randomElement($users));

            $manager->persist($item);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            PlanteFixtures::class,
            NiveauFixtures::class,
        ];
    }
}

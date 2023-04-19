<?php

namespace App\DataFixtures;

use App\Entity\Niveau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class NiveauFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $object = (new Niveau())
            ->setNiveau('Commun')
            ->setColor('#3DA6DB')
            ->setTauxDrop(80)
        ;
        $manager->persist($object);


        $object = (new Niveau())
            ->setNiveau('Rare')
            ->setColor('#B73DB7')
            ->setTauxDrop(19)
        ;
        $manager->persist($object);


        $object = (new Niveau())
            ->setNiveau('Mythique')
            ->setColor('#C2D04B')
            ->setTauxDrop(1)
        ;
        $manager->persist($object);


        $manager->flush();
    }
}

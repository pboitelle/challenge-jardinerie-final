<?php

namespace App\DataFixtures;

use App\Entity\Plante;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class PlanteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $response = file_get_contents('https://opendata.paris.fr/api/records/1.0/search/?dataset=les-arbres-plantes&q=&exclude.genre=Platanus&exclude.espece=hippocastanum');

        $data = json_decode($response, true);

        for ($i = 0; $i < 10; $i++) {
            $object = (new Plante())
                ->setEspece($data['records'][$i]['fields']['espece'])
                ->setGenre($data['records'][$i]['fields']['libellefrancais'])
                ;
            $manager->persist($object);
        }

        $manager->flush();
    }
}

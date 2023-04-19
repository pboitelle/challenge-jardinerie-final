<?php

namespace App\DataFixtures;

use App\Entity\Plante;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class PlanteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $response = file_get_contents('https://trefle.io/api/v1/plants?token=uVxoNzzrB-3jHf0jRJj_bWYSSWsAU_OivmTxfTZJKg0');

        $data = json_decode($response, true);

        for ($i = 0; $i < 10; $i++) {
            $object = (new Plante())
                ->setEspece($data['data'][$i]['family'])
                ->setGenre($data['data'][$i]['genus'])
                ;
            $manager->persist($object);
        }

        $manager->flush();
    }
}

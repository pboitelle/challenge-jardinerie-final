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

        for ($i = 0; $i < 20; $i++) {
            $object = (new Plante())
                ->setEspece($data['data'][$i]['scientific_name'])
                ->setGenre($data['data'][$i]['genus'])
                ->setImageUrl($data['data'][$i]['image_url'])
                ;
            $manager->persist($object);
        }

        $manager->flush();
    }
}

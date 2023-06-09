<?php

namespace App\DataFixtures;

use App\Entity\Plante;
use App\Entity\Blog;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class BlogFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $plantes = $manager->getRepository(Plante::class)->findAll();
        $user = $manager->getRepository(User::class)->findOneBy(['email' => 'blog@blog.fr']);
        $user2 = $manager->getRepository(User::class)->findOneBy(['email' => 'blog2@blog2.fr']);

        for ($i = 0; $i < 3; $i++) {

            $blog = new Blog();
            $blog->setTitle($faker->sentence(1));
            $blog->setDescription($faker->paragraph(1));
            $blog->setArea($faker->paragraph(10));
            $blog->setCreatedAt(new \DateTimeImmutable());
            $blog->setUpdateAt(new \DateTimeImmutable());
            $blog->setPlante($faker->unique()->randomElement($plantes));
            $blog->setUserId($user);
            $blog->setIsValidate(false);

            $manager->persist($blog);
        }

        for ($i = 0; $i < 3; $i++) {

            $blog = new Blog();
            $blog->setTitle($faker->sentence(1));
            $blog->setDescription($faker->paragraph(1));
            $blog->setArea($faker->paragraph(10));
            $blog->setCreatedAt(new \DateTimeImmutable());
            $blog->setUpdateAt(new \DateTimeImmutable());
            $blog->setPlante($faker->unique()->randomElement($plantes));
            $blog->setUserId($user2);
            $blog->setIsValidate(false);

            $manager->persist($blog);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PlanteFixtures::class,
            UserFixtures::class,
        ];
    }
}

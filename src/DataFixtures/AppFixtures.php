<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $post = new Post();

            // Faker me génére aléatoirement du contenu.
            $title = $faker->words(3, true);
            $content = $faker->words(10, true);

            $post->setTitle($title)->setContent($content);

            $manager->persist($post);
        }

        $manager->flush();
    }
}

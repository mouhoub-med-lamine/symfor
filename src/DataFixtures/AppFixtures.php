<?php

namespace App\DataFixtures;
use Faker\Factory;
use Faker\Generator;
use App\Entity\Ingredient;
use App\Entity\Recepie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i=1; $i <= 10 ; $i++) { 
            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word())
                ->setPrice($this->faker->numberBetween($min = 10, $max = 3000))
                ->setRating($this->faker->numberBetween(1 , 5));
            $manager->persist(object: $ingredient);
        }

        for ($i=1; $i <= 5 ; $i++) { 
            $recepie = new Recepie();
            $recepie->setName($this->faker->word())
                ->setPrice($this->faker->numberBetween($min = 10, $max = 3000))
                ->setDescription($this->faker->text())
                ->setIsFavorite($this->faker->boolean);
                for ($i=0; $i < mt_rand(5 , 9); $i++) { 
                    $recepie->addIngregient($ingredient[mt_rand(1 , count($ingredient) - 1)]);
                }
            $manager->persist(object: $ingredient);
        }

        $manager->flush();
    }
}

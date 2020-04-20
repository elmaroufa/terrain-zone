<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Property;
use Faker\Factory;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist$product);
        $faker = Factory::create('fr_FR');
        for($i=0;$i<50;$i++){
            $property = new Property();
            $property->setTitle($faker->words(3,true))
                     ->setDescription($faker->sentences(4,true))
                     ->setSurface($faker->numberBetween(20,350))
                     ->setRooms($faker->numberBetween(2,10))
                     ->setBedrooms($faker->numberBetween(1,9))
                     ->setFloor($faker->numberBetween(0,15))
                     ->setPrice($faker->numberBetween(2000,3000))
                     ->setHeat($faker->numberBetween(0,count(Property::HEAT)-1))
                     ->setCity($faker->city)
                     ->setAddress($faker->address)
                     ->setPostalCode($faker->postcode)
                     ->setSold(false);
                     $manager->persist($property);
        }
        $manager->flush();
    }
}

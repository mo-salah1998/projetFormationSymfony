<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\Faker;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create();
        for ($i=0; $i<10;$i++){
            $Participant=new Participant();
            $Participant -> setNomP($faker->lastName);
            $Participant ->setPrenomP($faker->firstName);
            $Participant -> setEmail($faker->email);
            $Participant -> setNomCours("symfony");

            $manager->persist($Participant);
        }
        $manager->flush();
    }
}

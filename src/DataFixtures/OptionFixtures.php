<?php

namespace App\DataFixtures;

use App\Entity\Option;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class OptionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 10; $i++) { 
            # code...
            $option = new Option();
            $option->setOptionKey('option' .$i)->setValue('value' .$i);
            $manager->persist($option);
            echo 'option created: ' . $option->getOptionKey() . PHP_EOL;
            $this->addReference('option' . $i, $option);
        }

        $manager->flush();
    }
}

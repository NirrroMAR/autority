<?php

namespace App\DataFixtures;


use App\Entity\Tag;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TagFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $date = new \DatetimeImmutable('now');
    

        for ($i = 0; $i < 50; $i++) {
            $tag = new Tag();
            $tag->setName('tag' . $i)
                ->setSlug("tag-" .$i);

            $manager->persist($tag);
            echo 'tag created: ' . $tag->getName() . PHP_EOL;
            $this->addReference('tag' . $i, $tag);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PostFixtures::class,
        ];
    }
}

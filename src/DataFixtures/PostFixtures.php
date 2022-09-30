<?php

namespace App\DataFixtures;


use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PostFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $date = new \DatetimeImmutable('now');
    

        for ($i = 0; $i < 50; $i++) {
            $post = new Post();
            $post->setTitle('post' . $i)
                ->setContent('content' . $i)
                ->setCreatedAt($date)
                ->setUpdatedAt($date)
                ->setAuthor($this->getReference('admin1'));

            // $manager->persist($post);
            echo 'post created: ' . $post->getTitle() . PHP_EOL;
            $this->addReference('post' . $i, $post);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}

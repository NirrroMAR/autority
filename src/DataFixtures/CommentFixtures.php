<?php

namespace App\DataFixtures;


use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $date = new \DatetimeImmutable('now');
    

        for ($i = 0; $i < 100; $i++) {
            $comment = new Comment();
            $comment->setContent('content' . $i)
                ->setCreatedAt($date)
                ->setAuthor($this->getReference('admin1'))
                ->setPost($this->getReference('post'.$i));

            $manager->persist($comment);
            echo 'comment created: ' . $comment->getContent() . PHP_EOL;
            $this->addReference('comment' . $i, $comment);
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

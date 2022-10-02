<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // create nico user
        $date = new \DatetimeImmutable('now');
        $admin = new User();
        $password = $this->hasher->hashPassword($admin, '0000');
        $admin->setEmail('martins.n.adm@gmail.com')
            ->setPassword($password)
            ->setRoles(['ROLE_ADMIN'])
            ->setCreatedAt($date)
            ->setUpdatedAt($date)
            ->setAvatar('https://avatars.githubusercontent.com/u/113260786?v=4');

        $manager->persist($admin);
        $this->addReference('admin1', $admin);
        echo 'user created: ' . $admin->getEmail() . PHP_EOL;

        // create titouan user
        $admin = new User();
        $password = $this->hasher->hashPassword($admin, '0000');
        $admin->setEmail('titouan.thd@gmail.com')
            ->setPassword($password)
            ->setRoles(['ROLE_ADMIN'])
            ->setCreatedAt($date)
            ->setUpdatedAt($date)
            ->setAvatar('https://avatars.githubusercontent.com/u/113260787?v=4');

        $manager->persist($admin);
        $this->addReference('admin2', $admin);
        echo 'user created: ' . $admin->getEmail() . PHP_EOL;

        // create 5 Fake user
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $password = $this->hasher->hashPassword($user, '0000');
            $user->setEmail('user' . $i . '@gmail.com')
                ->setPassword($password)
                ->setRoles(['ROLE_USER'])
                ->setCreatedAt($date)
                ->setUpdatedAt($date)
                ->setAvatar('https://avatars.githubusercontent.com/u/11326078'.$i.'?v=4');

            $manager->persist($user);
            echo 'user created: ' . $user->getEmail() . PHP_EOL;
            $this->addReference('user' . $i, $user);
        }
        $manager->flush();
    }
}

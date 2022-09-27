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
        $date = new \DatetimeImmutable('now');
        $user = new User();
        $password = $this->hasher->hashPassword($user, '0000');
        $user->setEmail('martins.n.adm@gmail.com')
        ->setPassword($password)
        ->setRoles(['ROLE_ADMIN'])
        ->setCreatedAt($date)
        ->setUpdatedAt($date);

        $manager->persist($user);
echo 'user created: ' . $user->getEmail();
for ($i=0; $i < 50 ; $i++) { 
    # code...
    $user = new User();
    $password = $this->hasher->hashPassword($user, '0000');
    $user->setEmail('user'.$i.'@gmail.com')
    ->setPassword($password)
    ->setRoles(['ROLE_USER'])
    ->setCreatedAt($date)
    ->setUpdatedAt($date);

    $manager->persist($user);
echo 'user created: ' . $user->getEmail();
}
        $manager->flush();
    }
}

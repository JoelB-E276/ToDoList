<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Symfony\Config\SecurityConfig;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
     private $passwordHasher;

     public function __construct(UserPasswordHasherInterface $passwordHasher)
     {
        $this->passwordHasher = $passwordHasher;
     }


    public function load(ObjectManager $manager)
    {
           $user = new Users();
           $user->setEmail("philippe.jordan@norimmo.com");
           $user->setFirstname("Philippe");
           $user->setLastname("Jordan");
           $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            '123456'
           ));
           $manager->persist($user);

           $user2 = new Users();
           $user2->setEmail("StanislasBorrowitz@norimmo.com");
           $user2->setFirstname("Stanislas");
           $user2->setLastname("Borrowitz");
           $user2->setPassword($this->passwordHasher->hashPassword(
            $user2,
            '123456'
           ));
           $manager->persist($user2);

        $manager->flush();
        $this->addReference("Philippe", $user);
        $this->addReference("Stan", $user2);


    }
    
}

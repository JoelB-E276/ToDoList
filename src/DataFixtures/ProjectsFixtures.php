<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Users;
use App\Entity\Project;
use App\DataFixtures\UserFixtures;
use Symfony\Config\SecurityConfig;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProjectsFixtures extends Fixture  implements DependentFixtureInterface
{
     


    public function load(ObjectManager $manager)
    {
           $project1 = new Project();
           $project1->setBeginning(new \DateTime());
           $project1->setStatus("En cours");
           $project1->setEnd(new \DateTime ("2021-12-11 00:00:00"));
           $project1->setTitle("Pose fenêtres Mme & M. Cavalier ");
           $project1->setContent("Huisserie + 4 x Fenêtre coulissante Aluminium 115X120 cm blanc, 2 vantaux gauche/droite ");
           $project1->setArchived("non");
          // Pour faire référence à user de la précédente fixture
           $project1->setUsers($this->getReference('Philippe'));
        
           $manager->persist($project1);

           $project2 = new Project();
           $project2->setBeginning(new \DateTime());
           $project2->setStatus("En cours");
           $project2->setEnd(new \DateTime ("2022-01-11 12:00:00"));
           $project2->setTitle("Porte Mme Margelle");
           $project2->setContent(" Porte d'entrée Bois chêne Borgo Premium H.215 x l.90 cm pleine , poussant droit ");
           $project2->setArchived("non");
           $project2->setUsers($this->getReference('Philippe'));

           $manager->persist($project2);

           $project3 = new Project();
           $project3->setBeginning(new \DateTime());
           $project3->setStatus("En cours");
           $project3->setEnd(new \DateTime ("2021-12-20 08:30:00"));
           $project3->setTitle("Sol Mme & Dupré");
           $project3->setContent(" Plancher brut en pin maritime, long. 200cm x larg. 14.5cm x Ep. 21mm ");
           $project3->setArchived("non");
           $project3->setUsers($this->getReference('Philippe'));

           $manager->persist($project3);

        $manager->flush();

    }
    // Pour gérer l'ordre de passage des fixtures
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}

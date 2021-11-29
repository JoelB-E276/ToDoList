<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Users;
use App\Entity\Task;
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
        ///////////PROJECT///////////

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
           $project3->setTitle("Sol Mme & M. Dupré");
           $project3->setContent(" Plancher brut en pin maritime, long. 200cm x larg. 14.5cm x Ep. 21mm ");
           $project3->setArchived("non");
           $project3->setUsers($this->getReference('Philippe'));

           $manager->persist($project3);

           $project4 = new Project();
           $project4->setBeginning(new \DateTime());
           $project4->setStatus("En cours");
           $project4->setEnd(new \DateTime ("2021-12-20 08:30:00"));
           $project4->setTitle("Test projet 4");
           $project4->setContent(" Content Proj 4");
           $project4->setArchived("non");
           $project4->setUsers($this->getReference('Stan'));

           $manager->persist($project4);

           $this->addReference("P1", $project1);
           $this->addReference("P2", $project2);
           $this->addReference("P3", $project3);

         ///////////TASK///////////
           $task1 = new Task();
           $task1->setBeginning(new \DateTime());
           $task1->setStatus("Terminé");
           $task1->setEnd(new \DateTime ("2021-12-11 00:00:00"));
           $task1->setTitle("Fournitures Cavalier ");
           $task1->setContent("Contact fournisseurs devis fenêtres");
           $task1->setProject($this->getReference('P1'));
        
           $manager->persist($task1);

           $task2 = new Task();
           $task2->setBeginning(new \DateTime());
           $task2->setStatus("En cours");
           $task2->setEnd(new \DateTime ("2022-01-11 12:00:00"));
           $task2->setTitle("Relevé de mesures Mme Margelle");
           $task2->setContent("Prendre rendez-vous");
           $task2->setProject($this->getReference('P2'));

           $manager->persist($task2);

           $task3 = new Task();
           $task3->setBeginning(new \DateTime());
           $task3->setStatus("En cours");
           $task3->setEnd(new \DateTime ("2021-12-20 08:30:00"));
           $task3->setTitle("Intérim");
           $task3->setContent("Contacter Manpower");
           $task3->setProject($this->getReference('P3'));

           $manager->persist($task3);

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

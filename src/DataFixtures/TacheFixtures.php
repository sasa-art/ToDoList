<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Tache;

class TacheFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $table = ['A faire', 'En cours', 'terminée'];

        for ($i = 1; $i <= 25; ++$i) {
            $rand = array_rand($table);
            $tache = new Tache();
            $tache->setTitle("Titre de la tache n°$i")
                  ->setDescription("Description de la tache n°$i")
                  ->setStatus($table[$rand])
                  ->setCreatedAt(new \DateTime());

            $manager->persist($tache);
        }

        $manager->flush();
    }
}

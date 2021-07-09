<?php

namespace App\DataFixtures;
use App\Entity\Rdv;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $rdv = new Rdv();
        $rdv->setPatient('65');
        $rdv->setSymptomes('54');
        $rdv->setPlace('sbitar bou7ajla');
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', '2021-07-08 14:00:00');
        $rdv->setDate($date);
        $rdv->setTester('Ali Rebhi');
        $rdv->setContent('variable zeyda');
        $manager->persist($rdv);

        $rdv = new Rdv();
        $rdv->setPatient('13');
        $rdv->setSymptomes('16');
        $rdv->setPlace('sbitar rabta');
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', '2021-07-06 15:00:00');
        $rdv->setDate($date);
        $rdv->setTester('Ali Rebhi');
        $rdv->setContent('variable zeyda');
        $manager->persist($rdv);

        $manager->flush();
    }
}

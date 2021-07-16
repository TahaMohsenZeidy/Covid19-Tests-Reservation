<?php

namespace App\DataFixtures;
use App\Entity\MedicalHistory;
use App\Entity\Patient;
use App\Entity\Place;
use App\Entity\Rdv;
use App\Entity\Symptomes;
use App\Entity\Tester;
use App\Entity\Times;
use App\Entity\Travel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadPatients($manager);
        $this->loadMedicalHistory($manager);
        $this->loadSymptomes($manager);
        $this->loadPlace($manager);
        $this->loadTester($manager);
        $this->loadTimes($manager);
        $this->loadRdvs($manager);
    }

    public function loadRdvs(ObjectManager $manager){
        $symp = $this->getReference('symp');
        $patient = $this->getReference('admin_patient');
        $place = $this->getReference('place');
        $rdv = new Rdv();
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', '2021-07-08 14:00:00');
        $rdv->setDate($date);
        $rdv->setResult('positive');
        $rdv->setPatient($patient);
        $rdv->setSymptomes($symp);
        $rdv->setPlace($place);
        $manager->persist($rdv);
        $manager->flush();
    }

    public function loadPatients(ObjectManager $manager){
        $patient = new Patient();
        $patient->setFirstname('Taha Mohsen');
        $patient->setLastname('Zeidy');
        $patient->setIdentifier(11621994);
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', '1998-12-01 15:00:00');
        $patient->setBirthdate($date);
        $patient->setNationality('Tunisian');
        $patient->setEmail('zeidytahamohsen@gmail.com');
        $patient->setGsm(50056505);
        $patient->setGender('Male');
        $patient->setAddress('Graa Benour - Lessouda - Sidi Bouzid');
        $patient->setAge(25);
        $this->addReference('admin_patient', $patient);
        $manager->persist($patient);
        $manager->flush();
    }

    public function loadMedicalHistory(ObjectManager $manager){
        $patient = $this->getReference('admin_patient');
        $medHist = new MedicalHistory();
        $medHist->setDisease('Diabetes');
        $medHist->setMedecine1('Aspirine');
        $medHist->setAnalyse1('bloot test');
        $medHist->setPatient($patient);
        $manager->persist($medHist);
        $manager->flush();
    }

    public function loadSymptomes(ObjectManager $manager){
        $symp = new Symptomes();
        $symp->setCold(true);
        $symp->setFever(false);
        $symp->setCough(true);
        $symp->setFatigue(false);
        $symp->setDiarrhea(true);
        $symp->setBleeding(true);
        $symp->setHeadache(false);
        $symp->setMusclePain(true);
        $symp->setVomiting(true);
        $symp->setHardBreathing(true);
        $symp->setAbdominalPain(true);
        $symp->setMassGathering(true);
        $symp->setCaseContact(true);
        $this->addReference('symp', $symp);
        $manager->persist($symp);
        $manager->flush();
    }

    public function loadPlace(ObjectManager $manager){
        $place = new Place();
        $place->setCountry('Tunisia');
        $place->setFloor('1st');
        $place->setResult('positive');
        $place->setRoom('room 5');
        $place->setKit(25);
        $this->addReference('place', $place);
        $manager->persist($place);
        $manager->flush();
    }

    public function loadTravel(ObjectManager $manager){
        $travel = new Travel();
        $travel->setDestination('Paris');
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', '2021-07-01 07:00:00');
        $travel->setFlyDate($date);
        $manager->persist($travel);
        $manager->flush();
    }

    public function loadTester(ObjectManager $manager){
        $place = $this->getReference('place');
        $tester = new Tester();
        $tester->setIdentifier('15487452');
        $tester->setLastname('bessalah');
        $tester->setFirstname('Ali');
        $tester->setDepartment('surgen');
        $tester->setPosition('manager');
        $tester->setPlace($place);
        $manager->persist($tester);
        $manager->flush();
    }

    public function loadTimes(ObjectManager $manager){
        $place = $this->getReference('place');
        $times = new Times();
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', '2021-07-01 00:00:00');
        $times->setDate($date);
        $times->setTime($date);
        $times->setPlace($place);
        $manager->persist($times);
        $manager->flush();
    }
}

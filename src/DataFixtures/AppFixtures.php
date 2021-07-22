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
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var Factory
     */
    private $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadPatients($manager);
        $this->loadMedicalHistory($manager);
        $this->loadSymptomes($manager);
        $this->loadPlace($manager);
        $this->loadTester($manager);
        $this->loadTimes($manager);
        $this->loadTravel($manager);
        $this->loadRdvs($manager);
    }

    public function loadRdvs(ObjectManager $manager){
        $symp = $this->getReference('symp_3');
        $patient = $this->getReference('admin_patient_6');
        $place = $this->getReference('place_4');
        $travel = $this->getReference('travel_8');
        for ($i=0; $i<50; $i++){
            $rdv = new Rdv();
            $rdv->setDate($this->faker->dateTimeThisYear);
            $rdv->setResult($this->faker->realText());
            $rdv->setPatient($patient);
            $rdv->setTravel($travel);
            $rdv->setSymptomes($symp);
            $rdv->setPlace($place);
            $this->setReference("rdv_$i", $rdv);
            $manager->persist($rdv);
        }
        $manager->flush();
    }

    public function loadPatients(ObjectManager $manager){
        for ($i=0; $i<10; $i++){
            $patient = new Patient();
            $patient->setFirstname($this->faker->firstName);
            $patient->setLastname($this->faker->lastName);
            $patient->setIdentifier($this->passwordEncoder->encodePassword($patient, '11621994'));
            $patient->setBirthdate($this->faker->dateTimeThisCentury);
            $patient->setNationality($this->faker->country);
            $patient->setEmail($this->faker->email);
            $patient->setGsm($this->faker->phoneNumber);
            $patient->setGender('Male');
            $patient->setAddress($this->faker->address);
            $patient->setAge($this->faker->randomNumber());
            $this->addReference("admin_patient_$i", $patient);
            $manager->persist($patient);
        }
        $manager->flush();
    }

    public function loadMedicalHistory(ObjectManager $manager){
        $patient = $this->getReference('admin_patient_6');
        for ($i=0; $i<50; $i++){
            for ($j=0; $j< rand(1, 5); $j++){
                $medHist = new MedicalHistory();
                $medHist->setDisease($this->faker->realText());
                $medHist->setAnalyse1($this->faker->realText());
                $medHist->setAnalyse($this->faker->realText());
                $medHist->setMedecine1($this->faker->realText());
                $medHist->setMedecine2($this->faker->realText());
                $medHist->setMedecine3($this->faker->realText());
                $medHist->setScan($this->faker->realText());
                $medHist->setScan1($this->faker->realText());
                $medHist->setPatient($patient);
                $manager->persist($medHist);
            }
        }
        $manager->flush();
    }

    public function loadSymptomes(ObjectManager $manager){
        for ($i=0; $i<10; $i++){
            $symp = new Symptomes();
            $symp->setCold($this->faker->boolean());
            $symp->setFever($this->faker->boolean());
            $symp->setCough($this->faker->boolean());
            $symp->setFatigue($this->faker->boolean());
            $symp->setDiarrhea($this->faker->boolean());
            $symp->setBleeding($this->faker->boolean());
            $symp->setHeadache($this->faker->boolean());
            $symp->setMusclePain($this->faker->boolean());
            $symp->setVomiting($this->faker->boolean());
            $symp->setHardBreathing($this->faker->boolean());
            $symp->setAbdominalPain($this->faker->boolean());
            $symp->setMassGathering($this->faker->boolean());
            $symp->setCaseContact($this->faker->boolean());
            $this->addReference("symp_$i", $symp);
            $manager->persist($symp);
        }
        $manager->flush();
    }

    public function loadPlace(ObjectManager $manager){
        for ($i=0; $i<10; $i++){
            $place = new Place();
            $place->setCountry($this->faker->country);
            $place->setFloor($this->faker->buildingNumber);
            $place->setResult($this->faker->realText("negative"));
            $place->setRoom($this->faker->randomNumber());
            $place->setKit($this->faker->randomNumber());
            $this->addReference("place_$i", $place);
            $manager->persist($place);
        }
        $manager->flush();
    }

    public function loadTravel(ObjectManager $manager){
        for ($i=0; $i<10; $i++){
            $travel = new Travel();
            $travel->setDestination($this->faker->country);
            $travel->setFlyDate($this->faker->dateTimeThisYear);
            $this->addReference("travel_$i", $travel);
            $manager->persist($travel);
        }
        $manager->flush();
    }

    public function loadTester(ObjectManager $manager){
        $place = $this->getReference('place_4');
        for ($i=0; $i<10; $i++){
            $tester = new Tester();
            $tester->setIdentifier($this->passwordEncoder->encodePassword(
                $tester,
                '11621994'
            ));
            $tester->setLastname($this->faker->lastName);
            $tester->setFirstname($this->faker->firstName);
            $tester->setDepartment($this->faker->email);
            $tester->setPosition($this->faker->company);
            $tester->setPlace($place);
            $manager->persist($tester);
        }
        $manager->flush();
    }

    public function loadTimes(ObjectManager $manager){
        $place = $this->getReference('place_4');
        for ($i=0; $i<10; $i++){
            $times = new Times();
            $times->setDate($this->faker->dateTimeThisYear);
            $times->setTime($this->faker->dateTimeThisYear);
            $times->setPlace($place);
            $manager->persist($times);
        }
        $manager->flush();
    }
}

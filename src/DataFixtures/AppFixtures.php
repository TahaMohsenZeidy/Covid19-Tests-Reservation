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
use App\Security\TokenGenerator;
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

    private const USERS = [
        [
            'firstname' => 'Ali',
            'lastname' => 'Ben Yedder',
            'birthdate' => '21-08-1997 00:00:00',
            'nationality' => 'libyan',
            'email' => 'ali.benyedder@gmail.com',
            'address' => 'sousse - tunisie',
            'age' => 22,
            'gender' => 'male',
            'identifier' => '11223344',
            'gsm' => '92844871',
            'roles' => [Patient::ROLE_SUPERADIMN],
            'enabled' => true
        ],
        [
            'firstname' => 'Imen',
            'lastname' => 'Khalfallah',
            'birthdate' => '05-01-2001 00:00:00',
            'nationality' => 'tunisian',
            'email' => 'imen.khalfallah@gmail.com',
            'address' => 'gabes - tunisie',
            'age' => 20,
            'gender' => 'female',
            'identifier' => '44332211',
            'gsm' => '50546285',
            'roles' => [Patient::ROLE_WRITER],
            'enabled' => true
        ],
        [
            'firstname' => 'Amine',
            'lastname' => 'Marzouqi',
            'birthdate' => '31-04-1994 00:00:00',
            'nationality' => 'algerian',
            'email' => 'amine.marzouqi@gmail.com',
            'address' => 'beja - tunisie',
            'age' => 30,
            'gender' => 'male',
            'identifier' => '77889944',
            'gsm' => '50468457',
            'roles' => [Patient::ROLE_EDITOR],
            'enabled' => false
        ],
        [
            'firstname' => 'Racha',
            'lastname' => 'Khaled',
            'birthdate' => '06-06-1998 00:00:00',
            'nationality' => 'syrian',
            'email' => 'racha.khaled@gmail.com',
            'address' => 'beirout - syria',
            'age' => 23,
            'gender' => 'female',
            'identifier' => '66996699',
            'gsm' => '78245698',
            'roles' => [Patient::ROLE_ADMIN],
            'enabled' => true
        ]
    ];

    /**
     * @var TokenGenerator
     */
    private $tokenGenerator;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, TokenGenerator $tokenGenerator)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Factory::create();
        $this->tokenGenerator = $tokenGenerator;
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
        $place = $this->getReference('place_4');
        $travel = $this->getReference('travel_8');
        for ($i=0; $i<50; $i++){
            $rdv = new Rdv();
            $rdv->setDate($this->faker->dateTimeThisYear);
            $rdv->setResult($this->faker->realText());
            $patientReference = $this->getRandomPatientReference($rdv);
            $rdv->setPatient($patientReference);
            $rdv->setTravel($travel);
            $rdv->setSymptomes($symp);
            $rdv->setPlace($place);
            $this->setReference("rdv_$i", $rdv);
            $manager->persist($rdv);
        }
        $manager->flush();
    }

    public function loadPatients(ObjectManager $manager){
        foreach (self::USERS as $user){
            $patient = new Patient();
            $patient->setFirstname($user['firstname']);
            $patient->setLastname($user['lastname']);
            $patient->setIdentifier($this->passwordEncoder->encodePassword($patient, $user['identifier']));
            $patient->setNationality($user['nationality']);
            $date = new \DateTime($user['birthdate']);
            $patient->setBirthdate($date);
            $patient->setEmail($user['email']);
            $patient->setGsm($user['gsm']);
            $patient->setGender($user['gender']);
            $patient->setAddress($user['address']);
            $patient->setAge($user['age']);
            $patient->setEnabled($user['enabled']);
            if (!$user['enabled']){
                $patient->setConfirmationToken(
                    $this->tokenGenerator->getRandomSecureToken()
                );
            }
            $patient->setRoles($user['roles']);
            $this->addReference("patient_".$user['email'], $patient);
            $manager->persist($patient);
        }
        $manager->flush();
    }

    public function loadMedicalHistory(ObjectManager $manager){
        for ($i=0; $i<20; $i++){
                $medHist = new MedicalHistory();
                $medHist->setDisease($this->faker->realText());
                $medHist->setMedecine1($this->faker->realText());
                $medHist->setMedecine2($this->faker->realText());
                $medHist->setMedecine3($this->faker->realText());
                $patientReference = $this->getRandomPatientReference($medHist);
                $medHist->setPatient($patientReference);
                $manager->persist($medHist);
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

    public function getRandomPatientReference($entity): Patient
    {
        $randomUser = self::USERS[rand(0, 3)];

        if (($entity instanceof Rdv || $entity instanceof MedicalHistory) && count(array_intersect($randomUser['roles'], [Patient::ROLE_SUPERADIMN, Patient::ROLE_ADMIN, Patient::ROLE_WRITER]))){
            return $this->getRandomPatientReference($entity);
        }

        return $this->getReference('patient_'. $randomUser['email']);
    }
}

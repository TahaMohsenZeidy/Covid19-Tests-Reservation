<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     itemOperations={"get"},
 *     collectionOperations={"post"},
 *     normalizationContext={"groups"={"read"}}
 * )
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 * @method string getUserIdentifier()
 * @UniqueEntity("email")
 * @UniqueEntity("gsm")
 */

class Patient implements UserInterface
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     * @Assert\NotBlank()
     * @Assert\Length(min=4, max=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     * @Assert\NotBlank()
     * @Assert\Length(min=4, max=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/(^[0-9]*$)/",
     *     message="Identifier must contain at least 8 digits and should not contain letters"
     * )
     */
    private $identifier;

    /**
     * @ORM\Column(type="date")
     * @Groups({"read"})
     * @Assert\NotBlank()
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     * @Assert\NotBlank()
     * @Assert\Length(min=4, max=255)
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=255)
     */
    private $address;

    public function __construct()
    {
        $this->rdv = new ArrayCollection();
        $this->medical_history = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gsm;

    /**
     * @ORM\Column(type="integer")
     *
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MedicalHistory", mappedBy="patient")
     */
    private $medical_history;

    /**
     * @return Collection|MedicalHistory[]
     */
    public function getMedicalHistory(): Collection
    {
        return $this->medical_history;
    }


    /**
    * @ORM\OneToMany(targetEntity="App\Entity\Rdv", mappedBy="patient")
    */
    private $rdv;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getGsm(): ?string
    {
        return $this->gsm;
    }

    public function setGsm(string $gsm): self
    {
        $this->gsm = $gsm;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Collection|Rdv[]
     */
    public function getRdv(): Collection
    {
        return $this->rdv;
    }


    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->identifier;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {

    }

    /**
     * @inheritDoc
     */
    public function getUsername(): ?string
    {
        return $this->identifier;
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }
}

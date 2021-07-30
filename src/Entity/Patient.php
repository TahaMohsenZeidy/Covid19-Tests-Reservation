<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
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
 *      itemOperations={
 *         "get"={
 *               "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *               "normalization_context"={
 *                     "groups"={"get"}
 *                }
 *          },
 *         "put"={
 *                "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object == user",
 *                "denormalization_context"={
 *                     "groups"={"put"}
 *                },
 *                "normalization_context"={
 *                     "groups"={"get"}
 *               }
 *          }
 *      },
 *      collectionOperations={
 *         "post"={
 *              "denormalization_context"={
 *                  "groups"={"post"}
 *              },
 *              "normalization_context"={
 *                  "groups"={"get"}
 *              }
 *         }
 *     }
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
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "put", "post", "get_rdvs_with_all"})
     * @Assert\Length(min=4, max=255)
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "put", "post", "get_rdvs_with_all"})
     * @Assert\Length(min=4, max=255)
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Groups({"post", "put"})
     * @Assert\Regex(
     *     pattern="/(^[0-9]*$)/",
     *     message="Identifier must contain at least 8 digits and should not contain letters"
     * )
     */
    private $identifier;

    /**
     * @ORM\Column(type="date")
     * @Groups({"get", "put", "post"})
     * @Assert\NotBlank()
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "put", "post"})
     * @Assert\Length(min=4, max=255)
     * @Assert\NotBlank()
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post"})
     * @Assert\Email()
     * @Assert\NotBlank()
     *
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "put", "post"})
     * @Assert\Length(min=5, max=255)
     * @Assert\NotBlank()
     */
    private $address;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Groups({"get", "put", "post"})
     */
    private $gsm;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Groups({"get", "put", "post"})
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Groups({"get", "put", "post"})
     */
    private $gender;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MedicalHistory", mappedBy="patient")
     * @Groups({"get"})
     * @ApiSubresource()
     */
    private $medical_history;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rdv", mappedBy="patient")
     * @Groups({"get"})
     * @ApiSubresource()
     */
    private $rdv;

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
     * @return Collection|MedicalHistory[]
     */
    public function getMedicalHistory(): Collection
    {
        return $this->medical_history;
    }
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
    public function eraseCredentials(){}
    /**
     * @inheritDoc
     */
    public function getUsername(): ?string
    {
        return $this->email;
    }
    public function __call($name, $arguments){}
}

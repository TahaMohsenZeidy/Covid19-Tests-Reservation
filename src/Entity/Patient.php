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
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\ResetIdentifierAction;

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
 *          },
 *         "put-reset-identifier"={
 *                "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object == user",
 *                "method"="PUT",
 *                "path"="/patients/{id}/reset-identifier",
 *                "controller"=ResetIdentifierAction::class,
 *                "denormalization_context"={
 *                     "groups"={"put-reset-identifier"}
 *                }
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
    const ROLE_WRITER = 'ROLE_WRITER';
    const ROLE_EDITOR = 'ROLE_EDITOR';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_SUPERADIMN = 'ROLE_SUPERADIMN';

    const DEFAULT_ROLES = [self::ROLE_WRITER];

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
     * @Assert\Length(min=4, max=255, groups={"post"})
     * @Assert\NotBlank(groups={"post", "put"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "put", "post", "get_rdvs_with_all"})
     * @Assert\Length(min=4, max=255, groups={"post"})
     * @Assert\NotBlank(groups={"post", "put"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"post"})
     * @Groups({"post"})
     * @Assert\Regex(
     *     pattern="/(^[0-9]*$)/",
     *     message="Identifier must contain at least 8 digits and should not contain letters",
     *     groups={"post"}
     * )
     */
    private $identifier;

    /**
     * @ORM\Column(type="date")
     * @Groups({"get", "put", "post"})
     * @Assert\Date(groups={"post", "put"})
     * @Assert\NotBlank(groups={"post"})
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "put", "post"})
     * @Assert\Length(min=4, max=255, groups={"post", "put"})
     * @Assert\NotBlank()
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post", "get-admin", "get-owner"})
     * @Assert\Email(groups={"post"})
     * @Assert\NotBlank(groups={"post"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "put", "post"})
     * @Assert\Length(min=5, max=255, groups={"post", "put"})
     * @Assert\NotBlank()
     */
    private $address;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"post", "put"})
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
     * @Assert\NotBlank(groups={"post"})
     * @Groups({"get", "put", "post"})
     */
    private $gender;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MedicalHistory", mappedBy="patient")
     * @Groups({"get", "get-admin", "get-owner"})
     * @ApiSubresource()
     */
    private $medical_history;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rdv", mappedBy="patient")
     * @Groups({"get"})
     * @ApiSubresource()
     */
    private $rdv;

    /**
     * @ORM\Column(type="simple_array", length=200)
     * @Groups({"get-admin", "get-owner"})
     */
    private $roles;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $identifierChangeDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @Assert\NotBlank(groups={"put-reset-identifier"})
     * @Groups({"put-reset-identifier"})
     * @Assert\Regex(
     *     pattern="/(^[0-9]*$)/",
     *     message="Identifier must contain at least 8 digits and should not contain letters",
     *     groups={"put-reset-identifier"}
     * )
     */
    private $newIdentifier;

    /**
     * @Groups({"put-reset-identifier"})
     * @Assert\NotBlank(groups={"put-reset-identifier"})
     * @Assert\Expression(
     *     "this.getNewIdentifier() === this.getNewRetypedIdentifier()",
     *     message="Identifiers does not match",
     *     groups={"put-reset-identifier"}
     * )
     */
    private $newRetypedIdentifier;

    /**
     * @Groups({"put-reset-identifier"})
     * @Assert\NotBlank(groups={"put-reset-identifier"})
     * @UserPassword(groups={"put-reset-identifier"})
     */
    private $oldIdentifier;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $confirmationToken;

    public function __construct()
    {
        $this->rdv = new ArrayCollection();
        $this->medical_history = new ArrayCollection();
        $this->roles = self::DEFAULT_ROLES;
        $this->enabled = false;
        $this->confirmationToken = null;
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

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles){
        $this->roles = $roles;
    }


    public function getPassword()
    {
        return $this->identifier;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials(){}

    public function getUsername(): ?string
    {
        return $this->email;
    }
    public function __call($name, $arguments){}

    public function getNewIdentifier(): ?string
    {
        return $this->newIdentifier;
    }

    public function setNewIdentifier($newIdentifier): void
    {
        $this->newIdentifier = $newIdentifier;
    }

    public function getNewRetypedIdentifier(): ?string
    {
        return $this->newRetypedIdentifier;
    }

    public function setNewRetypedIdentifier($newRetypedIdentifier): void
    {
        $this->newRetypedIdentifier = $newRetypedIdentifier;
    }

    public function getOldIdentifier(): ?string
    {
        return $this->oldIdentifier;
    }

    public function setOldIdentifier($oldIdentifier): void
    {
        $this->oldIdentifier = $oldIdentifier;
    }

    public function getIdentifierChangeDate()
    {
        return $this->identifierChangeDate;
    }

    public function setIdentifierChangeDate($identifierChangeDate): void
    {
        $this->identifierChangeDate = $identifierChangeDate;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken($confirmationToken): void
    {
        $this->confirmationToken = $confirmationToken;
    }
}

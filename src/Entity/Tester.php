<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TesterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 *@ApiResource(
 *     itemOperations={"get"},
 *     collectionOperations={"post"},
 *     normalizationContext={"groups"={"read"}}
 * )
 * @ORM\Entity(repositoryClass=TesterRepository::class)
 * @method string getUserIdentifier()
 * @UniqueEntity("identifier")
 * @UniqueEntity("elecmail")
 */

class Tester implements UserInterface
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
     * @Assert\Regex(
     *     pattern="/(^[0-9]*$)/",
     *     message="Identifier must contain at least 8 digits and should not contain letters"
     * )
     */
    private $identifier;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     * @Assert\NotBlank()
     * @Assert\Length(min=4, max=255)
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $elecmail;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Place", inversedBy="tester")
     * @ORM\JoinColumn(nullable=true)
     */
    private $place;

// --------------------------- Getters and Setters Begin -------------------

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->place = $place;
        return $this;
    }

    // --------------------------- Getters and Setters Begin -------------------

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

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->elecmail;
    }

    public function setDepartment(string $department): self
    {
        $this->elecmail = $department;

        return $this;
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
        // TODO: Implement getPassword() method.
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
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RdvRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     itemOperations={"get"},
 *     collectionOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=RdvRepository::class)
 */
class Rdv
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Patient", inversedBy="rdv")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }


    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;
        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Symptomes", inversedBy="rdv")
     * @ORM\JoinColumn(nullable=false)
     */
    private $symptomes;

    public function getSymptomes(): ?Symptomes
    {
        return $this->symptomes;
    }

    public function setSymptomes(?Symptomes $symptomes): self
    {
        $this->symptomes = $symptomes;
        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Travel", inversedBy="rdv")
     * @ORM\JoinColumn(nullable=true)
     */
    private $travel;

    public function getTravel(): ?Travel
    {
        return $this->travel;
    }

    public function setTravel(?Travel $travel): self
    {
        $this->travel = $travel;
        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Place", inversedBy="rdv")
     * @ORM\JoinColumn(nullable=false)
     */
    private $place;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $result;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }


    public function setPlace(?Place $place): self
    {
        $this->place = $place;
        return $this;
    }


    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }


    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(string $result): self
    {
        $this->result = $result;

        return $this;
    }
}

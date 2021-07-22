<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MedicalHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=MedicalHistoryRepository::class)
 */
class MedicalHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $disease;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $medecine_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $medecine_2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $medecine_3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $scan;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $scan_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $analyse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $analyse_1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Patient", inversedBy="medical_history")
     */
    private $patient;

    /**
     * @return Patient
     */
    public function getPatient(): Patient
    {
        return $this->patient;
    }


    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDisease(): ?string
    {
        return $this->disease;
    }

    public function setDisease(string $disease): self
    {
        $this->disease = $disease;

        return $this;
    }

    public function getMedecine1(): ?string
    {
        return $this->medecine_1;
    }

    public function setMedecine1(string $medecine_1): self
    {
        $this->medecine_1 = $medecine_1;

        return $this;
    }

    public function getMedecine2(): ?string
    {
        return $this->medecine_2;
    }

    public function setMedecine2(string $medecine_2): self
    {
        $this->medecine_2 = $medecine_2;

        return $this;
    }

    public function getMedecine3(): ?string
    {
        return $this->medecine_3;
    }

    public function setMedecine3(string $medecine_3): self
    {
        $this->medecine_3 = $medecine_3;

        return $this;
    }

    public function getScan(): ?string
    {
        return $this->scan;
    }

    public function setScan(?string $scan): self
    {
        $this->scan = $scan;

        return $this;
    }

    public function getScan1(): ?string
    {
        return $this->scan_1;
    }

    public function setScan1(?string $scan_1): self
    {
        $this->scan_1 = $scan_1;

        return $this;
    }

    public function getAnalyse(): ?string
    {
        return $this->analyse;
    }

    public function setAnalyse(?string $analyse): self
    {
        $this->analyse = $analyse;

        return $this;
    }

    public function getAnalyse1(): ?string
    {
        return $this->analyse_1;
    }

    public function setAnalyse1(?string $analyse_1): self
    {
        $this->analyse_1 = $analyse_1;

        return $this;
    }
}

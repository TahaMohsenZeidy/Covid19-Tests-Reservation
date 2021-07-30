<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MedicalHistoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"get"}},
 *     itemOperations={
 *         "get"={
 *              "normalization_context"={
 *                  "groups"={"get"}
 *              }
 *          }
 *      },
 *     collectionOperations={
 *         "get"={
 *               "normalization_context"={
 *                  "groups"={"get"}
 *              }
 *          },
 *         "post"={
 *              "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *               "denormalization_context"={
 *                   "groups"={"post"}
 *               }
 *          }
 *      }
 * )
 * @ORM\Entity(repositoryClass=MedicalHistoryRepository::class)
 */
class MedicalHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get", "post"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get", "post"})
     */
    private $disease;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get", "post"})
     */
    private $medecine1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get", "post"})
     */
    private $medecine2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get", "post"})
     */
    private $medecine3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get", "post"})
     */
    private $scan;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get", "post"})
     */
    private $scan1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get", "post"})
     */
    private $analyse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get", "post"})
     */
    private $analyse1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Patient", inversedBy="medical_history")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"post"})
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDisease(): ?string
    {
        if ($this->disease == null){
            echo("hooooooooooh");
        }
        return $this->disease;
    }

    public function setDisease(string $disease): self
    {
        $this->disease = $disease;
        return $this;
    }

    public function getMedecine1(): ?string
    {
        return $this->medecine1;
    }

    public function setMedecine1(string $medecine1): self
    {
        $this->medecine1 = $medecine1;

        return $this;
    }

    public function getMedecine2(): ?string
    {
        return $this->medecine2;
    }

    public function setMedecine2(string $medecine2): self
    {
        $this->medecine2 = $medecine2;

        return $this;
    }

    public function getMedecine3(): ?string
    {
        return $this->medecine3;
    }

    public function setMedecine3(string $medecine3): self
    {
        $this->medecine3 = $medecine3;

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
        return $this->scan1;
    }

    public function setScan1(?string $scan1): self
    {
        $this->scan1 = $scan1;

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
        return $this->analyse1;
    }

    public function setAnalyse1(?string $analyse1): self
    {
        $this->analyse1 = $analyse1;

        return $this;
    }
}

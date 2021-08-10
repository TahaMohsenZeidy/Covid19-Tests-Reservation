<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\MedicalHistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     attributes={"order"={"id": "DESC"},
 *         "pagination_client_enabled"=true,
 *         "pagination_client_items_per_page"=true
 *     },
 *     normalizationContext={"groups"={"get"}},
 *     itemOperations={
 *         "put",
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
            echo("the disease is null");
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

    public function __toString()
    {
        return $this->id;
    }

}

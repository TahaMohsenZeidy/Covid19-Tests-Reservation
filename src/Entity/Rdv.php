<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\RdvRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 
 * @ApiResource(
 *     attributes={"order"={"date": "DESC"}},
 *     itemOperations={
 *         "get"={
 *              "normalization_context"={
 *                   "groups"={"get_rdvs_with_all"}
 *              }
 *         },
 *         "put"={
 *              "access_control"="is_granted('ROLE_EDITOR') or (is_granted('ROLE_WRITER') and object.getPatient() == user)"
 *          }
 *      },
 *     collectionOperations={
 *         "get",
 *         "post"={
 *              "access_control"="is_granted('ROLE_WRITER')"
 *          }
 *      },
 *     denormalizationContext={
 *          "groups"={"post"}
 *     }
 * )
 * @ORM\Entity(repositoryClass=RdvRepository::class)
 */
class Rdv
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get_rdvs_with_all"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Patient", inversedBy="rdv")
     * @ORM\JoinColumn(nullable=false)
     * @ApiSubresource()
     * @Groups({"get_rdvs_with_all"})
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Symptomes", inversedBy="rdv")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"post", "get_rdvs_with_all"})
     */
    private $symptomes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Travel", inversedBy="rdv")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"post", "get_rdvs_with_all"})
     */
    private $travel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Place", inversedBy="rdv")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"post", "get_rdvs_with_all"})
     */
    private $place;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get_rdvs_with_all"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"post", "get_rdvs_with_all"})
     */
    private $result;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getPatient(): ?Patient
    {
        return $this->patient;
    }
    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;
        return $this;
    }
    public function getSymptomes(): ?Symptomes
    {
        return $this->symptomes;
    }
    public function setSymptomes(?Symptomes $symptomes): self
    {
        $this->symptomes = $symptomes;
        return $this;
    }
    public function getTravel(): ?Travel
    {
        return $this->travel;
    }
    public function setTravel(?Travel $travel): self
    {
        $this->travel = $travel;
        return $this;
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

    public function __toString(): string
    {
        return $this->result;
    }
}

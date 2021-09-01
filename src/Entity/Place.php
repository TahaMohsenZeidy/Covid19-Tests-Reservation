<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\PlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     itemOperations={"get"},
 *     collectionOperations={"get", "post"}
 * )
 * @ORM\Entity(repositoryClass=PlaceRepository::class)
 */
class Place
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Times", mappedBy="place")
     * @ApiSubresource()
     */
    private $times;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tester", mappedBy="place")
     * @ApiSubresource()
     * @Groups({"get_rdvs_with_all"})
     */
    private $tester;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rdv", mappedBy="place")
     */
    private $rdv;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_rdvs_with_all"})
     */
    private $room;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_rdvs_with_all"})
     */
    private $floor;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_rdvs_with_all"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $kit;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_rdvs_with_all"})
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $result;

    public function __construct()
    {
        $this->tester = new ArrayCollection();
        $this->times = new ArrayCollection();
        $this->rdv = new ArrayCollection();
    }


    // ------------------------ Begin Getters and Setters ---------------

    /**
     * @return Collection|Tester[]
     */
    public function getTester(): Collection
    {
        return $this->tester;
    }

    /**
     * @return Collection|Times[]
     */
    public function getTimes(): Collection
    {
        return $this->times;
    }

    /**
     * @return Collection|Rdv[]
     */
    public function getRdv(): Collection
    {
        return $this->rdv;
    }



    // ------------------------ End Getters and Setters -----------------------------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getRoom(): ?string
    {
        return $this->room;
    }

    public function setRoom(string $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getFloor(): ?string
    {
        return $this->floor;
    }

    public function setFloor(string $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getKit(): ?int
    {
        return $this->kit;
    }

    public function setKit(int $kit): self
    {
        $this->kit = $kit;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

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

    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name): void
    {
        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }

}

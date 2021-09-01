<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TimesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

/**
 * @ApiFilter(
 *     DateFilter::class,
 *     properties={
 *         "timeBegin"
 *     }
 * )
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=TimesRepository::class)
 */
class Times
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get"})
     */
    private $timeBegin;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get"})
     */
    private $timeFinish;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Place", inversedBy="times")
     * @ORM\JoinColumn(nullable=false)
     */
    private $place;

//-----------------------------Getters and setters begin ------------


    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->place = $place;
        return $this;
    }

// ------------------------------ Getters and setters end --------------------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeBegin()
    {
        return $this->timeBegin;
    }

    public function getTimeFinish()
    {
        return $this->timeFinish;
    }

    public function setTimeBegin($timeBegin): void
    {
        $this->timeBegin = $timeBegin;
    }

    public function setTimeFinish($timeFinish): void
    {
        $this->timeFinish = $timeFinish;
    }

    public function __toString(): string
    {
        return $this->timeBegin->format('Y-m-d H:i:s');
    }


}

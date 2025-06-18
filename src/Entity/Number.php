<?php

namespace App\Entity;

use App\Repository\NumberRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'number')]
#[ORM\Entity(repositoryClass: NumberRepository::class)]
class Number
{
    #[ORM\Column(name: "id_number")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idNumber = null;

    #[ORM\ManyToOne(targetEntity: Custom::class, inversedBy: "numbers")]
    #[ORM\JoinColumn(name: "id_custom", referencedColumnName: "id_custom")]
    private ?Custom $custom = null;

    #[ORM\Column(name: "number_x")]
    private ?int $numberX = null;

    #[ORM\Column(name: "number_y")]
    private ?int $numberY = null;

    #[ORM\Column(name: "number_width")]
    private ?int $numberWidth = null;

    #[ORM\Column(name: "number_height")]
    private ?int $numberHeight = null;

    #[ORM\Column(name: "number_type", length: 1)]
    private ?string $numberType = null;

    public function getIdNumber(): ?int
    {
        return $this->idNumber;
    }

    public function getCustom(): ?Custom
    {
        return $this->custom;
    }

    public function setCustom(?Custom $custom): static
    {
        $this->custom = $custom;
        return $this;
    }

    public function getNumberX(): ?int
    {
        return $this->numberX;
    }

    public function setNumberX(int $numberX): static
    {
        $this->numberX = $numberX;

        return $this;
    }

    public function getNumberY(): ?int
    {
        return $this->numberY;
    }

    public function setNumberY(int $numberY): static
    {
        $this->numberY = $numberY;

        return $this;
    }

    public function getNumberWidth(): ?int
    {
        return $this->numberWidth;
    }

    public function setNumberWidth(int $numberWidth): static
    {
        $this->numberWidth = $numberWidth;

        return $this;
    }

    public function getNumberHeight(): ?int
    {
        return $this->numberHeight;
    }

    public function setNumberHeight(int $numberHeight): static
    {
        $this->numberHeight = $numberHeight;

        return $this;
    }

    public function getNumberType(): ?string
    {
        return $this->numberType;
    }

    public function setNumberType(string $numberType): static
    {
        $this->numberType = $numberType;

        return $this;
    }
}

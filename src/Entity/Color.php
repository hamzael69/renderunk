<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Custom;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'color')]
#[ORM\Entity(repositoryClass: ColorRepository::class)]
class Color
{
    #[ORM\Column(name: "id_color")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idColor = null;

    #[ORM\Column(name: "color_name", length: 32)]
    private ?string $colorName = null;

    #[ORM\Column(name: "color_code", length: 8, nullable: true)]
    private ?string $colorCode = null;

    /**
     * @var Collection<int, Custom>
     */
    #[ORM\OneToMany(mappedBy: "color1Rel", targetEntity: Custom::class)]
    private Collection $color1s;

    /**
     * @var Collection<int, Custom>
     */
    #[ORM\OneToMany(mappedBy: "color2Rel", targetEntity: Custom::class)]
    private Collection $color2s;

    /**
     * @var Collection<int, Custom>
     */
    #[ORM\OneToMany(mappedBy: "color3Rel", targetEntity: Custom::class)]
    private Collection $color3s;

    /**
     * @var Collection<int, Custom>
     */
    #[ORM\OneToMany(mappedBy: "color4Rel", targetEntity: Custom::class)]
    private Collection $color4s;

    /**
     * @var Collection<int, Custom>
     */
    #[ORM\OneToMany(mappedBy: "color5Rel", targetEntity: Custom::class)]
    private Collection $color5s;

    public function __construct()
    {
        $this->color1s = new ArrayCollection();
        $this->color2s = new ArrayCollection();
        $this->color3s = new ArrayCollection();
        $this->color4s = new ArrayCollection();
        $this->color5s = new ArrayCollection();
    }

    public function getIdColor(): ?int
    {
        return $this->idColor;
    }

    public function getColorName(): ?string
    {
        return $this->colorName;
    }

    public function setColorName(string $colorName): static
    {
        $this->colorName = $colorName;

        return $this;
    }

    public function getColorCode(): ?string
    {
        return $this->colorCode;
    }

    public function setColorCode(?string $colorCode): static
    {
        $this->colorCode = $colorCode;

        return $this;
    }

    /**
     * @return Collection<int, Custom>
     */
    public function getColor1s(): Collection
    {
        return $this->color1s;
    }

    public function getColor2s(): Collection
    {
        return $this->color2s;
    }

    public function getColor3s(): Collection
    {
        return $this->color3s;
    }

    public function getColor4s(): Collection
    {
        return $this->color4s;
    }

    public function getColor5s(): Collection
    {
        return $this->color5s;
    }
}

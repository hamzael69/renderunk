<?php

namespace App\Entity;

use App\Repository\CustomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Product;
use App\Entity\Collar;
use App\Entity\Color;
use App\Entity\Text;
use App\Entity\Number;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'custom')]
#[ORM\Entity(repositoryClass: CustomRepository::class)]
class Custom
{
    #[ORM\Column(name: "id_custom")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idCustom = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: "customs")]
    #[ORM\JoinColumn(name: "id_product", referencedColumnName: "id_product")]
    private ?Product $product = null;

    #[ORM\Column(name: "color1", nullable: true)]
    private ?int $color1 = null;

    #[ORM\Column(name: "color2", nullable: true)]
    private ?int $color2 = null;

    #[ORM\Column(name: "color3", nullable: true)]
    private ?int $color3 = null;

    #[ORM\Column(name: "color4", nullable: true)]
    private ?int $color4 = null;

    #[ORM\Column(name: "color5", nullable: true)]
    private ?int $color5 = null;

    #[ORM\ManyToOne(targetEntity: Collar::class)]
    #[ORM\JoinColumn(name: "collar_type", referencedColumnName: "id")]
    private ?Collar $collar = null;

    #[ORM\ManyToOne(targetEntity: Color::class)]
    #[ORM\JoinColumn(name: "color1", referencedColumnName: "id")]
    private ?Color $color1Rel = null;

    #[ORM\ManyToOne(targetEntity: Color::class)]
    #[ORM\JoinColumn(name: "color2", referencedColumnName: "id")]
    private ?Color $color2Rel = null;

    #[ORM\ManyToOne(targetEntity: Color::class)]
    #[ORM\JoinColumn(name: "color3", referencedColumnName: "id")]
    private ?Color $color3Rel = null;

    #[ORM\ManyToOne(targetEntity: Color::class)]
    #[ORM\JoinColumn(name: "color4", referencedColumnName: "id")]
    private ?Color $color4Rel = null;

    #[ORM\ManyToOne(targetEntity: Color::class)]
    #[ORM\JoinColumn(name: "color5", referencedColumnName: "id")]
    private ?Color $color5Rel = null;

    /**
     * @var Collection<int, Text>
     */
    #[ORM\OneToMany(mappedBy: "custom", targetEntity: Text::class)]
    private Collection $texts;

    /**
     * @var Collection<int, Number>
     */
    #[ORM\OneToMany(mappedBy: "custom", targetEntity: Number::class)]
    private Collection $numbers;

    public function __construct()
    {
        $this->texts = new ArrayCollection();
        $this->numbers = new ArrayCollection();
    }

    public function getIdCustom(): ?int
    {
        return $this->idCustom;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;
        return $this;
    }

    public function getColor1(): ?int
    {
        return $this->color1;
    }

    public function setColor1(?int $color1): static
    {
        $this->color1 = $color1;

        return $this;
    }

    public function getColor2(): ?int
    {
        return $this->color2;
    }

    public function setColor2(?int $color2): static
    {
        $this->color2 = $color2;

        return $this;
    }

    public function getColor3(): ?int
    {
        return $this->color3;
    }

    public function setColor3(?int $color3): static
    {
        $this->color3 = $color3;

        return $this;
    }

    public function getColor4(): ?int
    {
        return $this->color4;
    }

    public function setColor4(?int $color4): static
    {
        $this->color4 = $color4;

        return $this;
    }

    public function getColor5(): ?int
    {
        return $this->color5;
    }

    public function setColor5(?int $color5): static
    {
        $this->color5 = $color5;

        return $this;
    }

    public function getCollar(): ?Collar
    {
        return $this->collar;
    }

    public function setCollar(?Collar $collar): static
    {
        $this->collar = $collar;
        return $this;
    }

    public function getColor1Rel(): ?Color
    {
        return $this->color1Rel;
    }

    public function setColor1Rel(?Color $color): static
    {
        $this->color1Rel = $color;
        return $this;
    }

    public function getColor2Rel(): ?Color
    {
        return $this->color2Rel;
    }

    public function setColor2Rel(?Color $color): static
    {
        $this->color2Rel = $color;
        return $this;
    }

    public function getColor3Rel(): ?Color
    {
        return $this->color3Rel;
    }

    public function setColor3Rel(?Color $color): static
    {
        $this->color3Rel = $color;
        return $this;
    }

    public function getColor4Rel(): ?Color
    {
        return $this->color4Rel;
    }

    public function setColor4Rel(?Color $color): static
    {
        $this->color4Rel = $color;
        return $this;
    }

    public function getColor5Rel(): ?Color
    {
        return $this->color5Rel;
    }

    public function setColor5Rel(?Color $color): static
    {
        $this->color5Rel = $color;
        return $this;
    }

    /**
     * @return Collection<int, Text>
     */
    public function getTexts(): Collection
    {
        return $this->texts;
    }

    public function addText(Text $text): static
    {
        if (!$this->texts->contains($text)) {
            $this->texts[] = $text;
            $text->setCustom($this);
        }
        return $this;
    }

    public function removeText(Text $text): static
    {
        if ($this->texts->removeElement($text)) {
            if ($text->getCustom() === $this) {
                $text->setCustom(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Number>
     */
    public function getNumbers(): Collection
    {
        return $this->numbers;
    }

    public function addNumber(Number $number): static
    {
        if (!$this->numbers->contains($number)) {
            $this->numbers[] = $number;
            $number->setCustom($this);
        }
        return $this;
    }

    public function removeNumber(Number $number): static
    {
        if ($this->numbers->removeElement($number)) {
            if ($number->getCustom() === $this) {
                $number->setCustom(null);
            }
        }
        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\TextRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'text')]
#[ORM\Entity(repositoryClass: TextRepository::class)]
class Text
{
    #[ORM\Column(name: "id_text")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idText = null;

    #[ORM\ManyToOne(targetEntity: Custom::class, inversedBy: "texts")]
    #[ORM\JoinColumn(name: "id_custom", referencedColumnName: "id_custom")]
    private ?Custom $custom = null;

    #[ORM\Column(name: "text", length: 512, nullable: true)]
    private ?string $text = null;

    #[ORM\Column(name: "text_x", nullable: true)]
    private ?int $textX = null;

    #[ORM\Column(name: "text_y", nullable: true)]
    private ?int $textY = null;

    #[ORM\Column(name: "text_width", nullable: true)]
    private ?int $textWidth = null;

    #[ORM\Column(name: "text_height", nullable: true)]
    private ?int $textHeight = null;

    #[ORM\Column(name: "angle")]
    private ?int $angle = null;

    #[ORM\Column(name: "color")]
    private ?int $color = null;

    public function getIdText(): ?int
    {
        return $this->idText;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getTextX(): ?int
    {
        return $this->textX;
    }

    public function setTextX(?int $textX): static
    {
        $this->textX = $textX;

        return $this;
    }

    public function getTextY(): ?int
    {
        return $this->textY;
    }

    public function setTextY(?int $textY): static
    {
        $this->textY = $textY;

        return $this;
    }

    public function getTextWidth(): ?int
    {
        return $this->textWidth;
    }

    public function setTextWidth(?int $textWidth): static
    {
        $this->textWidth = $textWidth;

        return $this;
    }

    public function getTextHeight(): ?int
    {
        return $this->textHeight;
    }

    public function setTextHeight(?int $textHeight): static
    {
        $this->textHeight = $textHeight;

        return $this;
    }

    public function getAngle(): ?int
    {
        return $this->angle;
    }

    public function setAngle(int $angle): static
    {
        $this->angle = $angle;

        return $this;
    }

    public function getColor(): ?int
    {
        return $this->color;
    }

    public function setColor(int $color): static
    {
        $this->color = $color;

        return $this;
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
}

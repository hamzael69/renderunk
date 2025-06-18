<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'image')]
#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Column(name: "id_image")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idImage = null;

    #[ORM\ManyToOne(targetEntity: Custom::class)]
    #[ORM\JoinColumn(name: "id_custom", referencedColumnName: "id_custom")]
    private ?Custom $custom = null;

    #[ORM\Column(name: "image_x", nullable: true)]
    private ?int $imageX = null;

    #[ORM\Column(name: "image_y", nullable: true)]
    private ?int $imageY = null;

    #[ORM\Column(name: "image_width", nullable: true)]
    private ?int $imageWidth = null;

    #[ORM\Column(name: "image_height", nullable: true)]
    private ?int $imageHeight = null;

    #[ORM\Column(name: "image_extension", length: 256, options: ["default" => 'png'])]
    private ?string $imageExtension = 'png';

    public function getIdImage(): ?int
    {
        return $this->idImage;
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

    public function getImageX(): ?int
    {
        return $this->imageX;
    }

    public function setImageX(?int $imageX): static
    {
        $this->imageX = $imageX;

        return $this;
    }

    public function getImageY(): ?int
    {
        return $this->imageY;
    }

    public function setImageY(?int $imageY): static
    {
        $this->imageY = $imageY;

        return $this;
    }

    public function getImageWidth(): ?int
    {
        return $this->imageWidth;
    }

    public function setImageWidth(?int $imageWidth): static
    {
        $this->imageWidth = $imageWidth;

        return $this;
    }

    public function getImageHeight(): ?int
    {
        return $this->imageHeight;
    }

    public function setImageHeight(?int $imageHeight): static
    {
        $this->imageHeight = $imageHeight;

        return $this;
    }

    public function getImageExtension(): ?string
    {
        return $this->imageExtension;
    }

    public function setImageExtension(string $imageExtension): static
    {
        $this->imageExtension = $imageExtension;

        return $this;
    }
}

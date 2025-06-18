<?php

namespace App\Entity;

use App\Repository\SportproductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'sportproduct')]
#[ORM\Entity(repositoryClass: SportproductRepository::class)]
class Sportproduct
{
    #[ORM\Id]
    #[ORM\Column(name: "id_sport", type: "integer")]
    private ?int $idSport = null;

    #[ORM\Id]
    #[ORM\Column(name: "id_product", type: "integer")]
    private ?int $idProduct = null;

    #[ORM\ManyToOne(targetEntity: Sport::class, inversedBy: "sportproducts")]
    #[ORM\JoinColumn(name: "id_sport", referencedColumnName: "id_sport")]
    private ?Sport $sport = null;

    #[ORM\ManyToOne(targetEntity: Product::class)]
#[ORM\JoinColumn(name: "id_product", referencedColumnName: "id_product")]
private ?Product $product = null;

public function getProduct(): ?Product
{
    return $this->product;
}

public function setProduct(?Product $product): static
{
    $this->product = $product;
    return $this;
}

    public function getIdSport(): ?int
    {
        return $this->idSport;
    }

    public function setIdSport(?int $idSport): static
    {
        $this->idSport = $idSport;
        return $this;
    }

    public function getIdProduct(): ?int
    {
        return $this->idProduct;
    }

    public function setIdProduct(?int $idProduct): static
    {
        $this->idProduct = $idProduct;
        return $this;
    }

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): static
    {
        $this->sport = $sport;
        return $this;
    }
}

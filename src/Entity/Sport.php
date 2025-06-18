<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Product;
use App\Entity\Sportproduct;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'sport')]
#[ORM\Entity(repositoryClass: SportRepository::class)]
class Sport
{
    #[ORM\Column(name: "id_sport")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idSport = null;

    #[ORM\Column(name: "name", length: 16, nullable: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: "sports")]
    private Collection $products;

    /**
     * @var Collection<int, Sportproduct>
     */
    #[ORM\OneToMany(mappedBy: "sport", targetEntity: Sportproduct::class)]
    private Collection $sportproducts;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->sportproducts = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addSport($this);
        }
        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            $product->removeSport($this);
        }
        return $this;
    }

    /**
     * @return Collection<int, Sportproduct>
     */
    public function getSportproducts(): Collection
    {
        return $this->sportproducts;
    }

    public function addSportproduct(Sportproduct $sportproduct): static
    {
        if (!$this->sportproducts->contains($sportproduct)) {
            $this->sportproducts[] = $sportproduct;
            $sportproduct->setSport($this);
        }
        return $this;
    }

    public function removeSportproduct(Sportproduct $sportproduct): static
    {
        if ($this->sportproducts->removeElement($sportproduct)) {
            if ($sportproduct->getSport() === $this) {
                $sportproduct->setSport(null);
            }
        }
        return $this;
    }
}

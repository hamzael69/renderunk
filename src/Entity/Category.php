<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'category')]
#[ORM\UniqueConstraint(name: 'id_category', columns: ['id_category'])]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Column(name: "id_category", type: "integer")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idCategory = null;

    #[ORM\Column(name: "name", length: 255)]
    private ?string $name = null;

    #[ORM\Column(name: "display_number")]
    private ?int $displayNumber = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: "categories")]
    #[ORM\JoinTable(
        name: "categoryproduct",
        joinColumns: [new ORM\JoinColumn(name: "id_category", referencedColumnName: "id_category")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "id_product", referencedColumnName: "id_product")]
    )]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->displayNumber = 3; // Valeur par défaut
    }

    public function getIdCategory(): ?int
    {
        return $this->idCategory;
    }

    // public function setIdCategory(int $idCategory): static
    // {
    //     $this->idCategory = $idCategory;

    //     return $this;
    // }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDisplayNumber(): ?int
    {
        return $this->displayNumber;
    }

    public function setDisplayNumber(int $displayNumber): static
    {
        $this->displayNumber = $displayNumber;

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
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        $this->products->removeElement($product);

        return $this;
    }
}

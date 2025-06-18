<?php

namespace App\Entity;

use App\Repository\CategoryproductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'categoryproduct')]
#[ORM\UniqueConstraint(name: 'catprod', columns: ['id_category', 'id_product'])]
#[ORM\Entity(repositoryClass: CategoryproductRepository::class)]
class Categoryproduct
{
    #[ORM\Column(name: "id_category")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    private ?int $idCategory = null;

    #[ORM\Column(name: "id_product")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    private ?int $idProduct = null;


    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(name: "id_category", referencedColumnName: "id_category")]
    private ?Category $category = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(name: "id_product", referencedColumnName: "id_product")]
    private ?Product $product = null;

    public function getIdCategory(): ?int
    {
        return $this->idCategory;
    }

    public function setIdCategory(int $idCategory): static
    {
        $this->idCategory = $idCategory;

        return $this;
    }

    public function getIdProduct(): ?int
    {
        return $this->idProduct;
    }

    public function setIdProduct(int $idProduct): static
    {
        $this->idProduct = $idProduct;

        return $this;
    }


    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;
        return $this;
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

}

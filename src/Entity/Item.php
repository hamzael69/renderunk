<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Custom;
use App\Entity\Material;
use App\Entity\Gender;
use App\Entity\Orders;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Table(name: 'item')]
#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Column(name: "id_item")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idItem = null;

    #[ORM\Column(name: "id_custom", nullable: true)]
    private ?int $idCustom = null;

    #[ORM\Column(name: "quantity", nullable: true)]
    private ?int $quantity = null;

    #[ORM\Column(name: "size", length: 128, nullable: true)]
    private ?string $size = null;

    #[ORM\Column(name: "id_gender", nullable: true)]
    private ?int $idGender = null;

    #[ORM\Column(name: "id_material")]
    private ?int $idMaterial = null;

    #[ORM\Column(name: "number", length: 255, nullable: true)]
    private ?string $number = null;

    #[ORM\Column(name: "comment", length: 512, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(name: "image", length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(targetEntity: Custom::class)]
    #[ORM\JoinColumn(name: "id_custom", referencedColumnName: "id_custom")]
    private ?Custom $custom = null;

    #[ORM\ManyToOne(targetEntity: Material::class)]
    #[ORM\JoinColumn(name: "id_material", referencedColumnName: "id_material")]
    private ?Material $material = null;

    #[ORM\ManyToOne(targetEntity: Gender::class, inversedBy: "items")]
    #[ORM\JoinColumn(name: "id_gender", referencedColumnName: "id_gender")]
    private ?Gender $gender = null;

    /**
     * @var Collection<int, Orders>
     */
    #[ORM\ManyToMany(targetEntity: Orders::class, inversedBy: "items")]
    #[ORM\JoinTable(
        name: "itemorder",
        joinColumns: [new ORM\JoinColumn(name: "id_item", referencedColumnName: "id_item")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "id_order", referencedColumnName: "id_order")]
    )]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getIdItem(): ?int
    {
        return $this->idItem;
    }

    public function getIdCustom(): ?int
    {
        return $this->idCustom;
    }

    public function setIdCustom(?int $idCustom): static
    {
        $this->idCustom = $idCustom;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getIdGender(): ?int
    {
        return $this->idGender;
    }

    public function setIdGender(?int $idGender): static
    {
        $this->idGender = $idGender;

        return $this;
    }

    public function getIdMaterial(): ?int
    {
        return $this->idMaterial;
    }

    public function setIdMaterial(int $idMaterial): static
    {
        $this->idMaterial = $idMaterial;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

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

    public function getMaterial(): ?Material
    {
        return $this->material;
    }

    public function setMaterial(?Material $material): static
    {
        $this->material = $material;
        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): static
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return Collection<int, Orders>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
        }
        return $this;
    }

    public function removeOrder(Orders $order): static
    {
        $this->orders->removeElement($order);
        return $this;
    }
}

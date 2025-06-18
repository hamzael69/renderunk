<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Item;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'material')]
#[ORM\UniqueConstraint(name: 'id_material', columns: ['id_material'])]
#[ORM\Entity(repositoryClass: MaterialRepository::class)]
class Material
{
    #[ORM\Column(name: "id_material")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idMaterial = null;

    #[ORM\Column(name: "name", length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(mappedBy: "material", targetEntity: Item::class)]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getIdMaterial(): ?int
    {
        return $this->idMaterial;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setMaterial($this);
        }
        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            if ($item->getMaterial() === $this) {
                $item->setMaterial(null);
            }
        }
        return $this;
    }
}

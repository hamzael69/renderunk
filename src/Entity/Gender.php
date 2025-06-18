<?php

namespace App\Entity;

use App\Repository\GenderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Item;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'gender')]
#[ORM\UniqueConstraint(name: 'id_gender', columns: ['id_gender'])]
#[ORM\Entity(repositoryClass: GenderRepository::class)]
class Gender
{
    #[ORM\Column(name: "id_gender")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idGender = null;

    #[ORM\Column(name: "name", length: 64)]
    private ?string $name = null;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(mappedBy: "gender", targetEntity: Item::class)]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getIdGender(): ?int
    {
        return $this->idGender;
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
            $item->setGender($this);
        }
        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            if ($item->getGender() === $this) {
                $item->setGender(null);
            }
        }
        return $this;
    }
}

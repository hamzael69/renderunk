<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Item;
use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'orders')]
#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Column(name: "id_order")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idOrder = null;

    #[ORM\Column(name: "id_user", nullable: true)]
    private ?int $idUser = null;

    #[ORM\Column(name: "date_order", type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOrder = null;

    #[ORM\Column(name: "customer", length: 256)]
    private ?string $customer = null;

    #[ORM\Column(name: "description", length: 256)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id_user")]
    private ?User $user = null;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\ManyToMany(targetEntity: Item::class, mappedBy: "orders")]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getIdOrder(): ?int
    {
        return $this->idOrder;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(?int $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getDateOrder(): ?\DateTimeInterface
    {
        return $this->dateOrder;
    }

    public function setDateOrder(?\DateTimeInterface $dateOrder): static
    {
        $this->dateOrder = $dateOrder;

        return $this;
    }

    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    public function setCustomer(string $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
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
            $item->addOrder($this);
        }
        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            $item->removeOrder($this);
        }
        return $this;
    }
}

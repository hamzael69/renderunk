<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Orders;

#[ORM\Table(name: 'user')]
#[ORM\UniqueConstraint(name: 'user_username_unique', columns: ['username'])]
#[ORM\UniqueConstraint(name: 'user_email_unique', columns: ['email'])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Column(name: "id_user", type: Types::BIGINT)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?string $idUser = null;

    #[ORM\Column(name: "firstname", length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(name: "lastname", length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(name: "username", length: 190)]
    private ?string $username = null;

    #[ORM\Column(name: "company", length: 255)]
    private ?string $company = null;

    #[ORM\Column(name: "siret", length: 255)]
    private ?string $siret = null;

    #[ORM\Column(name: "phone", length: 255)]
    private ?string $phone = null;

    #[ORM\Column(name: "email", length: 190)]
    private ?string $email = null;

    #[ORM\Column(name: "email_verified_at", type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $emailVerifiedAt = null;

    #[ORM\Column(name: "password", length: 255)]
    private ?string $password = null;

    #[ORM\Column(name: "active", options: ["default" => 0])]
    private ?int $active = 0;

    #[ORM\Column(name: "remember_token", length: 100, nullable: true)]
    private ?string $rememberToken = null;

    #[ORM\Column(name: "created_at", type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(name: "updated_at", type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    /**
     * @var Collection<int, Orders>
     */
    #[ORM\OneToMany(mappedBy: "user", targetEntity: Orders::class)]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getIdUser(): ?string
    {
        return $this->idUser;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getEmailVerifiedAt(): ?\DateTimeInterface
    {
        return $this->emailVerifiedAt;
    }

    public function setEmailVerifiedAt(?\DateTimeInterface $emailVerifiedAt): static
    {
        $this->emailVerifiedAt = $emailVerifiedAt;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(int $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function setRememberToken(?string $rememberToken): static
    {
        $this->rememberToken = $rememberToken;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

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
            $order->setUser($this);
        }
        return $this;
    }

    public function removeOrder(Orders $order): static
    {
        if ($this->orders->removeElement($order)) {
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }
        return $this;
    }
}

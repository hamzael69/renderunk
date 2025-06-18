<?php

namespace App\Entity;

use App\Repository\CollarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Custom;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'collar')]
#[ORM\Entity(repositoryClass: CollarRepository::class)]
class Collar
{
    #[ORM\Column(name: "id_collar")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idCollar = null;

    #[ORM\Column(name: "name", length: 16, nullable: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, Custom>
     */
    #[ORM\OneToMany(mappedBy: "collar", targetEntity: Custom::class)]
    private Collection $customs;

    public function __construct()
    {
        $this->customs = new ArrayCollection();
    }

    public function getIdCollar(): ?int
    {
        return $this->idCollar;
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
     * @return Collection<int, Custom>
     */
    public function getCustoms(): Collection
    {
        return $this->customs;
    }

    public function addCustom(Custom $custom): static
    {
        if (!$this->customs->contains($custom)) {
            $this->customs[] = $custom;
            $custom->setCollar($this);
        }
        return $this;
    }

    public function removeCustom(Custom $custom): static
    {
        if ($this->customs->removeElement($custom)) {
            if ($custom->getCollar() === $this) {
                $custom->setCollar(null);
            }
        }
        return $this;
    }
}

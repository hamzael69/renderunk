<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Sport;
use App\Entity\Custom;

#[ORM\Table(name: 'product')]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Column(name: "id_product")]
    #[ORM\Id]
    // #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $idProduct = null;

    #[ORM\Column(name: "name", length: 32, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(name: "type", nullable: true)]
    private ?int $type = null;

    #[ORM\Column(name: "has_collar", nullable: true)]
    private ?int $hasCollar = null;

    #[ORM\Column(name: "has_number", nullable: true)]
    private ?int $hasNumber = null;

    #[ORM\Column(name: "has_pictures", nullable: true)]
    private ?int $hasPictures = null;

    #[ORM\Column(name: "has_text", nullable: true)]
    private ?int $hasText = null;

    #[ORM\Column(name: "color_number", nullable: true)]
    private ?int $colorNumber = null;

    #[ORM\Column(name: "default_color_1")]
    private ?int $defaultColor1 = null;

    #[ORM\Column(name: "default_color_2")]
    private ?int $defaultColor2 = null;

    #[ORM\Column(name: "default_color_3")]
    private ?int $defaultColor3 = null;

    #[ORM\Column(name: "default_color_4")]
    private ?int $defaultColor4 = null;

    #[ORM\Column(name: "default_color_5")]
    private ?int $defaultColor5 = null;

    /**
     * @var Collection<int, Sport>
     */
    #[ORM\ManyToMany(targetEntity: Sport::class, inversedBy: "products")]
    #[ORM\JoinTable(
        name: "sportproduct",
        joinColumns: [new ORM\JoinColumn(name: "id_product", referencedColumnName: "id_product")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "id_sport", referencedColumnName: "id_sport")]
    )]
    private Collection $sports;

    /**
     * @var Collection<int, Custom>
     */
    #[ORM\OneToMany(mappedBy: "product", targetEntity: Custom::class)]
    private Collection $customs;

    /**
     * @var Collection<int, Category>
     * Inverse side of Category::$products
     */
    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: "products")]
    private Collection $categories;

    public function __construct()
    {
        $this->sports = new ArrayCollection();
        $this->customs = new ArrayCollection();
        $this->categories = new ArrayCollection();
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



    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getHasCollar(): ?int
    {
        return $this->hasCollar;
    }

    public function setHasCollar(?int $hasCollar): static
    {
        $this->hasCollar = $hasCollar;

        return $this;
    }

    public function getHasNumber(): ?int
    {
        return $this->hasNumber;
    }

    public function setHasNumber(?int $hasNumber): static
    {
        $this->hasNumber = $hasNumber;

        return $this;
    }

    public function getHasPictures(): ?int
    {
        return $this->hasPictures;
    }

    public function setHasPictures(?int $hasPictures): static
    {
        $this->hasPictures = $hasPictures;

        return $this;
    }

    public function getHasText(): ?int
    {
        return $this->hasText;
    }

    public function setHasText(?int $hasText): static
    {
        $this->hasText = $hasText;

        return $this;
    }

    public function getColorNumber(): ?int
    {
        return $this->colorNumber;
    }

    public function setColorNumber(?int $colorNumber): static
    {
        $this->colorNumber = $colorNumber;

        return $this;
    }

    public function getDefaultColor1(): ?int
    {
        return $this->defaultColor1;
    }

    public function setDefaultColor1(int $defaultColor1): static
    {
        $this->defaultColor1 = $defaultColor1;

        return $this;
    }

    public function getDefaultColor2(): ?int
    {
        return $this->defaultColor2;
    }

    public function setDefaultColor2(int $defaultColor2): static
    {
        $this->defaultColor2 = $defaultColor2;

        return $this;
    }

    public function getDefaultColor3(): ?int
    {
        return $this->defaultColor3;
    }

    public function setDefaultColor3(int $defaultColor3): static
    {
        $this->defaultColor3 = $defaultColor3;

        return $this;
    }

    public function getDefaultColor4(): ?int
    {
        return $this->defaultColor4;
    }

    public function setDefaultColor4(int $defaultColor4): static
    {
        $this->defaultColor4 = $defaultColor4;

        return $this;
    }

    public function getDefaultColor5(): ?int
    {
        return $this->defaultColor5;
    }

    public function setDefaultColor5(int $defaultColor5): static
    {
        $this->defaultColor5 = $defaultColor5;

        return $this;
    }

    /**
     * @return Collection<int, Sport>
     */
    public function getSports(): Collection
    {
        return $this->sports;
    }

    public function addSport(Sport $sport): static
    {
        if (!$this->sports->contains($sport)) {
            $this->sports[] = $sport;
        }
        return $this;
    }

    public function removeSport(Sport $sport): static
    {
        $this->sports->removeElement($sport);
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
            $custom->setProduct($this);
        }
        return $this;
    }

    public function removeCustom(Custom $custom): static
    {
        if ($this->customs->removeElement($custom)) {
            if ($custom->getProduct() === $this) {
                $custom->setProduct(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }



    // === AJOUTE CETTE MÉTHODE À LA FIN ===
    public function getPath(): string
    {
        return $this->getIdProduct();
    }
}

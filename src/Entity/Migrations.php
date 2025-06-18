<?php

namespace App\Entity;

use App\Repository\MigrationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'migrations')]
#[ORM\Entity(repositoryClass: MigrationsRepository::class)]
class Migrations
{
    #[ORM\Column(name: "id")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $id = null;

    #[ORM\Column(name: "migration", length: 255)]
    private ?string $migration = null;

    #[ORM\Column(name: "batch")]
    private ?int $batch = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMigration(): ?string
    {
        return $this->migration;
    }

    public function setMigration(string $migration): static
    {
        $this->migration = $migration;

        return $this;
    }

    public function getBatch(): ?int
    {
        return $this->batch;
    }

    public function setBatch(int $batch): static
    {
        $this->batch = $batch;

        return $this;
    }
}

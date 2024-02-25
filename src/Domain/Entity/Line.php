<?php

declare(strict_types=1);

namespace sample\Domain\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use sample\Repository\LineRepository;
use Symfony\Component\Clock\Clock;

/**
 * @final
 */
#[ORM\Entity(repositoryClass: LineRepository::class)]
#[ORM\Table(name: 'line', schema: 'fis')]
#[ORM\UniqueConstraint(name: 'line_revision_name_vehicle_code_unique_idx', columns: ['revision_id', 'name', 'vehicle_code'])]
class Line
{
    #[ORM\Id]
    #[ORM\GeneratedValue('SEQUENCE')]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 100)]
    private string $name;

    #[ORM\Column(name: 'vehicle_type', type: Types::STRING, length: 100)]
    private string $vehicleType;

    #[ORM\Column(name: 'vehicle_code', type: Types::INTEGER)]
    private int $vehicleCode;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $created;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updated;

    #[ORM\ManyToOne(targetEntity: Revision::class)]
    #[ORM\JoinColumn(name: 'revision_id', referencedColumnName: 'id', nullable: false)]
    private Revision $revision;

    public function __construct()
    {
        $this->created = Clock::get()->now();
        $this->updated = Clock::get()->now();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getVehicleType(): string
    {
        return $this->vehicleType;
    }

    public function setVehicleType(string $vehicleType): void
    {
        $this->vehicleType = $vehicleType;
    }

    public function getVehicleCode(): int
    {
        return $this->vehicleCode;
    }

    public function setVehicleCode(int $vehicleCode): void
    {
        $this->vehicleCode = $vehicleCode;
    }

    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }

    public function setCreated(DateTimeImmutable $created): void
    {
        $this->created = $created;
    }

    public function getUpdated(): DateTimeImmutable
    {
        return $this->updated;
    }

    public function setUpdated(DateTimeImmutable $updated): void
    {
        $this->updated = $updated;
    }

    public function getRevision(): Revision
    {
        return $this->revision;
    }

    public function setRevision(Revision $revision): Line
    {
        $this->revision = $revision;
        return $this;
    }
}

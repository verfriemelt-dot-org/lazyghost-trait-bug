<?php

declare(strict_types=1);

namespace sample\Domain\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use sample\Repository\StationPointMappingRepository;
use Symfony\Component\Clock\Clock;

/**
 * @final
 */
#[ORM\Entity(repositoryClass: StationPointMappingRepository::class)]
#[ORM\Table(name: 'stationpoint_mapping', schema: 'fis')]
class StationPointMapping
{
    #[ORM\Id]
    #[ORM\GeneratedValue('SEQUENCE')]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(name: 'point_id', type: Types::STRING, length: 50)]
    private string $pointId;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 255)]
    private string $name;

    #[ORM\Column(name: 'region', type: Types::STRING, length: 255, nullable: true)]
    private ?string $region = null;

    #[ORM\Column(name: 'longitude', type: Types::DECIMAL, precision: 13, scale: 10, nullable: true)]
    private ?string $longitude;

    #[ORM\Column(name: 'latitude', type: Types::DECIMAL, precision: 13, scale: 10, nullable: true)]
    private ?string $latitude;

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

    public function getPointId(): string
    {
        return $this->pointId;
    }

    public function setPoint(string $pointId): void
    {
        $this->pointId = $pointId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): void
    {
        $this->latitude = $latitude;
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

    public function setRevision(Revision $revision): StationPointMapping
    {
        $this->revision = $revision;
        return $this;
    }
}

<?php

declare(strict_types=1);

namespace sample\Domain\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use sample\Domain\PointType\PointType;
use sample\Repository\PointRepository;
use fiPoint;
use Symfony\Component\Clock\Clock;

/**
 * @final
 */
#[ORM\Entity(repositoryClass: PointRepository::class)]
#[ORM\Table(name: 'point', schema: 'fis')]
#[ORM\Index(name: 'point_revision_point_id_type_name_region_layer_idx', columns: ['revision_id', 'point_id', 'type', 'name', 'region', 'layer'])]
class Point
{
    #[ORM\Id]
    #[ORM\GeneratedValue('SEQUENCE')]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    /** @var Collection<int,Line> */
    #[ORM\ManyToMany(targetEntity: Line::class, cascade: ['persist'])]
    #[ORM\JoinTable(name: 'point_has_lines', schema: 'fis')]
    private Collection $lines;

    /** @var Collection<int,Point> */
    #[ORM\ManyToMany(targetEntity: Point::class, cascade: ['persist'])]
    #[ORM\JoinTable(name: 'point_has_points', schema: 'fis', joinColumns: new ORM\JoinColumn(name: 'point_source'), inverseJoinColumns: new ORM\JoinColumn(name: 'point_target'))]
    #[ORM\OrderBy(['id' => 'ASC'])]
    private Collection $childPoints;

    #[ORM\Column(name: 'point_id', type: Types::STRING, length: 50)]
    private string $pointId;

    #[ORM\Column(name: 'global_id', type: Types::STRING, length: 50, nullable: true)]
    private ?string $globalId = null;

    // PointType::STATION_POINT_TYPE->value
    #[ORM\Column(name: 'type', type: Types::INTEGER)]
    private int $type = 0;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 100)]
    private string $name;

    #[ORM\Column(name: 'region', type: Types::STRING, length: 100, nullable: true)]
    private ?string $region = null;

    #[ORM\Column(name: 'searchstring', type: Types::STRING, length: 200)]
    private ?string $searchString = null;

    /** @var fiPoint::POINT_LAYER_*|null */
    #[ORM\Column(name: 'layer', type: Types::STRING, length: 255)]
    private ?string $layer = null;

    #[ORM\Column(name: 'alias_names', type: Types::STRING, length: 255)]
    private ?string $aliasNames = null;

    #[ORM\Column(name: 'latitude', type: Types::DECIMAL, precision: 13, scale: 10, nullable: true)]
    private ?string $latitude = null;

    #[ORM\Column(name: 'longitude', type: Types::DECIMAL, precision: 13, scale: 10, nullable: true)]
    private ?string $longitude = null;

    #[ORM\Column(name: 'zoom_level', type: Types::INTEGER)]
    private int $zoomLevel = 2;

    #[ORM\Column(name: 'priority', type: Types::INTEGER)]
    private int $priority = 0;

    #[ORM\Column(name: 'last_line_update', type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $lastLineUpdate = null;

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
        $this->lines = new ArrayCollection();
        $this->childPoints = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getPointId(): string
    {
        return $this->pointId;
    }

    public function setPointId(string $pointId): self
    {
        $this->pointId = $pointId;
        return $this;
    }

    public function getGlobalId(): ?string
    {
        return $this->globalId;
    }

    public function setGlobalId(?string $globalId): self
    {
        $this->globalId = $globalId;
        return $this;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;
        return $this;
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

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;
        return $this;
    }

    public function getSearchString(): ?string
    {
        return $this->searchString;
    }

    public function setSearchString(?string $searchString): self
    {
        $this->searchString = $searchString;
        return $this;
    }

    /**
     * @return fiPoint::POINT_LAYER_*|null
     */
    public function getLayer(): ?string
    {
        return $this->layer;
    }

    /**
     * @param fiPoint::POINT_LAYER_*|null $layer
     *
     * @return $this
     */
    public function setLayer(?string $layer): self
    {
        $this->layer = $layer;
        return $this;
    }

    public function getAliasNames(): ?string
    {
        return $this->aliasNames;
    }

    public function setAliasNames(?string $aliasNames): self
    {
        $this->aliasNames = $aliasNames;
        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getZoomLevel(): int
    {
        return $this->zoomLevel;
    }

    public function setZoomLevel(int $zoomLevel): self
    {
        $this->zoomLevel = $zoomLevel;
        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;
        return $this;
    }

    public function getLastLineUpdate(): ?DateTimeImmutable
    {
        return $this->lastLineUpdate;
    }

    public function setLastLineUpdate(?DateTimeImmutable $lastLineUpdate): self
    {
        $this->lastLineUpdate = $lastLineUpdate;
        return $this;
    }

    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }

    public function setCreated(DateTimeImmutable $created): self
    {
        $this->created = $created;
        return $this;
    }

    public function getUpdated(): DateTimeImmutable
    {
        return $this->updated;
    }

    public function setUpdated(DateTimeImmutable $updated): self
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return Collection<int,Line>
     */
    public function getLines(): Collection
    {
        return $this->lines;
    }

    /**
     * @param Collection<int,Line> $lines
     */
    public function setLines(Collection $lines): self
    {
        $this->lines = $lines;
        return $this;
    }

    public function addLine(Line $line): self
    {
        if (!$this->lines->contains($line)) {
            $this->lines->add($line);
        }

        return $this;
    }

    /**
     * @return Collection<int,Point>
     */
    public function getChildPoints(): Collection
    {
        return $this->childPoints;
    }

    /**
     * @param Collection<int, Point> $childPoints
     */
    public function setChildPoints(Collection $childPoints): self
    {
        $this->childPoints = $childPoints;
        return $this;
    }

    public function addChildPoint(Point $point): self
    {
        if (!$this->childPoints->contains($point)) {
            $this->childPoints->add($point);
        }

        return $this;
    }

    public function getRevision(): Revision
    {
        return $this->revision;
    }

    public function setRevision(Revision $revision): Point
    {
        $this->revision = $revision;
        return $this;
    }

    public function generateSearchstring(): Point
    {
        $searchString = $this->getName();
        $region = $this->getRegion();

        if ($region !== null && $searchString !== $region) {
            $searchString = $searchString . ' ' . $region;
        }

        if (!empty($this->getAliasNames())) {
            $searchString .= ' ' . $this->getAliasNames();
        }

        $searchString = mb_strtolower($searchString);
        $searchString = str_replace(['ä', 'ö', 'ü', 'ß'], ['ae', 'oe', 'ue', 'ss'], $searchString);

        $this->setSearchString($searchString);

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace sample\Domain\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use sample\Domain\Common\AppStatus;
use sample\Domain\EntityInterface\Trackable;
use sample\Repository\AppRepository;
use Symfony\Component\Clock\Clock;
use Override;

/**
 * @final
 */
#[ORM\Entity(repositoryClass: AppRepository::class)]
#[ORM\Table(name: 'app', schema: 'fis')]
#[ORM\Index(name: 'app_personal_timetable_service_id_idx', columns: ['personal_timetable_service_id'])]
#[ORM\Index(name: 'app_point_verification_service_id_idx', columns: ['point_verification_service_id'])]
#[ORM\Index(name: 'app_surrounding_points_service_id_idx', columns: ['surrounding_points_service_id'])]
#[ORM\Index(name: 'app_station_monitor_service_id_idx', columns: ['station_monitor_service_id'])]
#[ORM\Index(name: 'app_report_folder_service_id_idx', columns: ['report_folder_service_id'])]
#[ORM\Index(name: 'app_station_point_lines_service_id_idx', columns: ['station_point_lines_service_id'])]
#[ORM\Index(name: 'app_station_map_folder_service_id_idx', columns: ['station_map_folder_service_id'])]
#[ORM\Index(name: 'app_provider_code_idx', columns: ['provider_code'])]
#[ORM\UniqueConstraint(name: 'app_identifier_unique_idx', columns: ['identifier'])]
#[ORM\UniqueConstraint(name: 'app_canonical_name_unique_idx', columns: ['canonical_name'])]
#[ORM\HasLifecycleCallbacks]
class App
{
    #[ORM\Id]
    #[ORM\GeneratedValue('SEQUENCE')]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(name: 'canonical_name', type: Types::STRING, length: 128)]
    private string $canonicalName;

    #[ORM\Column(name: 'environment', type: Types::SMALLINT)]
    private int $environment = 3;

    #[ORM\Column(name: 'version', type: Types::STRING, length: 20)]
    private string $version = '1.0';

    #[ORM\Column(name: 'identifier', type: Types::STRING, length: 128)]
    private string $identifier;

    #[ORM\Column(name: 'key', type: Types::STRING, length: 128)]
    private string $key;

    #[ORM\Column(name: 'status', type: Types::INTEGER)]
    private int $status = 1;

    #[ORM\OneToOne(targetEntity: Service::class)]
    #[ORM\JoinColumn(name: 'personal_timetable_service_id', nullable: true)]
    private ?Service $personalTimetableService = null;

    #[ORM\OneToOne(targetEntity: Service::class)]
    #[ORM\JoinColumn(name: 'point_verification_service_id', nullable: true)]
    private ?Service $pointVerificationService = null;

    #[ORM\OneToOne(targetEntity: Service::class)]
    #[ORM\JoinColumn(name: 'surrounding_points_service_id', nullable: true)]
    private ?Service $surroundingPointService = null;

    #[ORM\OneToOne(targetEntity: Service::class)]
    #[ORM\JoinColumn(name: 'station_monitor_service_id', nullable: true)]
    private ?Service $stationMonitorService = null;

    #[ORM\OneToOne(targetEntity: Service::class)]
    #[ORM\JoinColumn(name: 'report_folder_service_id', nullable: true)]
    private ?Service $reportFolderService = null;

    #[ORM\OneToOne(targetEntity: Service::class)]
    #[ORM\JoinColumn(name: 'station_point_lines_service_id', nullable: true)]
    private ?Service $stationPointLinesService = null;

    #[ORM\OneToOne(targetEntity: Service::class)]
    #[ORM\JoinColumn(name: 'station_map_folder_service_id', nullable: true)]
    private ?Service $stationMapFolderService = null;

    #[ORM\ManyToOne(targetEntity: Provider::class, inversedBy: 'apps')]
    #[ORM\JoinColumn(name: 'provider_code', referencedColumnName: 'code', nullable: false)]
    private Provider $provider;

    #[ORM\Column(name: 'comment', type: Types::STRING, length: 1024, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $created;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updated;

    #[ORM\Column(name: 'in_use', type: Types::BOOLEAN, options: ['default' => false])]
    private bool $inUse = false;

    public function __construct()
    {
        $this->created = Clock::get()->now();
        $this->updated = Clock::get()->now();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): App
    {
        $this->id = $id;
        return $this;
    }

    public function getCanonicalName(): string
    {
        return $this->canonicalName;
    }

    public function setCanonicalName(string $canonicalName): App
    {
        $this->canonicalName = $canonicalName;
        return $this;
    }

    public function getEnvironment(): int
    {
        return $this->environment;
    }

    public function setEnvironment(int $environment): App
    {
        $this->environment = $environment;
        return $this;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): App
    {
        $this->version = $version;
        return $this;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): App
    {
        $this->identifier = $identifier;
        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): App
    {
        $this->key = $key;
        return $this;
    }

    public function getStatus(): AppStatus
    {
        return AppStatus::from($this->status);
    }

    public function setStatus(AppStatus $status): App
    {
        $this->status = $status->value;
        return $this;
    }

    public function getPersonalTimetableService(): ?Service
    {
        return $this->personalTimetableService;
    }

    public function setPersonalTimetableService(?Service $personalTimetableService): App
    {
        $this->personalTimetableService = $personalTimetableService;
        return $this;
    }

    public function getPointVerificationService(): ?Service
    {
        return $this->pointVerificationService;
    }

    public function setPointVerificationService(?Service $pointVerificationService): App
    {
        $this->pointVerificationService = $pointVerificationService;
        return $this;
    }

    public function getSurroundingPointService(): ?Service
    {
        return $this->surroundingPointService;
    }

    public function setSurroundingPointService(?Service $surroundingPointService): App
    {
        $this->surroundingPointService = $surroundingPointService;
        return $this;
    }

    public function getStationMonitorService(): ?Service
    {
        return $this->stationMonitorService;
    }

    public function setStationMonitorService(?Service $stationMonitorService): App
    {
        $this->stationMonitorService = $stationMonitorService;
        return $this;
    }

    public function getReportFolderService(): ?Service
    {
        return $this->reportFolderService;
    }

    public function setReportFolderService(?Service $reportFolderService): App
    {
        $this->reportFolderService = $reportFolderService;
        return $this;
    }

    public function getStationPointLinesService(): ?Service
    {
        return $this->stationPointLinesService;
    }

    public function setStationPointLinesService(?Service $stationPointLinesService): App
    {
        $this->stationPointLinesService = $stationPointLinesService;
        return $this;
    }

    public function getStationMapFolderService(): ?Service
    {
        return $this->stationMapFolderService;
    }

    public function setStationMapFolderService(?Service $stationMapFolderService): App
    {
        $this->stationMapFolderService = $stationMapFolderService;
        return $this;
    }

    public function getProvider(): Provider
    {
        return $this->provider;
    }

    public function setProvider(Provider $provider): App
    {
        $this->provider = $provider;
        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): App
    {
        $this->comment = $comment;
        return $this;
    }

    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }

    public function setCreated(DateTimeImmutable $created): App
    {
        $this->created = $created;
        return $this;
    }

    public function getUpdated(): DateTimeImmutable
    {
        return $this->updated;
    }

    public function setUpdated(DateTimeImmutable $updated): App
    {
        $this->updated = $updated;
        return $this;
    }

    public function isInUse(): bool
    {
        return $this->inUse;
    }

    public function setInUse(bool $inUse): App
    {
        $this->inUse = $inUse;
        return $this;
    }
}

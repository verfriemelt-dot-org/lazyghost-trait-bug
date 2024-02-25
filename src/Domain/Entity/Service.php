<?php

declare(strict_types=1);

namespace sample\Domain\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use sample\Domain\EntityInterface\Trackable;
use sample\Repository\ServiceRepository;
use fiWebService;
use Symfony\Component\Clock\Clock;
use Override;

/**
 * @final
 */
#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[ORM\Table(name: 'service', schema: 'fis')]
#[ORM\UniqueConstraint(name: 'service_identifier_unique_idx', columns: ['identifier'])]
#[ORM\HasLifecycleCallbacks]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue('SEQUENCE')]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    /** @var class-string<fiWebService> */
    #[ORM\Column(name: 'identifier', type: Types::STRING, length: 128)]
    private string $identifier;

    #[ORM\Column(name: 'status', type: Types::INTEGER)]
    private int $status = 1;

    #[ORM\Column(name: 'comment', type: Types::STRING, length: 1024, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $created;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updated;

    #[ORM\Column(name: 'in_use', type: Types::BOOLEAN, options: ['default' => false])]
    private bool $inUse = false;

    #[ORM\ManyToOne(targetEntity: Provider::class)]
    #[ORM\JoinColumn(name: 'provider_code', referencedColumnName: 'code', nullable: false)]
    private Provider $provider;

    public function __construct()
    {
        $this->created = Clock::get()->now();
        $this->updated = Clock::get()->now();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Service
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return class-string<fiWebService>
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param class-string<fiWebService> $identifier
     */
    public function setIdentifier(string $identifier): Service
    {
        $this->identifier = $identifier;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): Service
    {
        $this->status = $status;
        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): Service
    {
        $this->comment = $comment;
        return $this;
    }

    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }

    public function setCreated(DateTimeImmutable $created): Service
    {
        $this->created = $created;
        return $this;
    }

    public function getUpdated(): DateTimeImmutable
    {
        return $this->updated;
    }

    public function setUpdated(DateTimeImmutable $updated): Service
    {
        $this->updated = $updated;
        return $this;
    }

    public function isInUse(): bool
    {
        return $this->inUse;
    }

    public function setInUse(bool $inUse): Service
    {
        $this->inUse = $inUse;
        return $this;
    }

    public function getProvider(): Provider
    {
        return $this->provider;
    }

    public function setProvider(Provider $provider): Service
    {
        $this->provider = $provider;
        return $this;
    }
}

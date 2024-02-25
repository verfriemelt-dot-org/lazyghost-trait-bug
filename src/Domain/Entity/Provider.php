<?php

declare(strict_types=1);

namespace sample\Domain\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use sample\Domain\EntityInterface\Trackable;
use sample\Repository\ProviderRepository;
use Symfony\Component\Clock\Clock;
use Override;

/**
 * @final
 */
#[ORM\Entity(repositoryClass: ProviderRepository::class)]
#[ORM\Table(name: 'provider', schema: 'fis')]
#[ORM\UniqueConstraint(name: 'provider_token_unique_idx', columns: ['token'])]
class Provider
{
    #[ORM\Id]
    #[ORM\Column(name: 'code', type: Types::INTEGER)]
    private int $code;

    #[ORM\Column(name: 'token', type: Types::STRING, length: 20)]
    private string $token;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 255)]
    private string $name;

    /** @var mixed[] */
    #[ORM\Column(name: 'config', type: Types::JSON, options: ['jsonb' => true, 'default' => '{}'])]
    private array $config = [];

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $created;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updated;

    #[ORM\Column(name: 'in_use', type: Types::BOOLEAN, options: ['default' => false])]
    private bool $inUse = false;

    #[ORM\Column(name: 'current_revision_number', type: Types::INTEGER, nullable: false)]
    private int $currentRevisionNumber = 1;

    /** @var Collection<int,App> */
    #[ORM\OneToMany(targetEntity: App::class, mappedBy: 'provider')]
    private Collection $apps;

    public function __construct()
    {
        $this->created = Clock::get()->now();
        $this->updated = Clock::get()->now();
        $this->apps = new ArrayCollection();
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): Provider
    {
        $this->code = $code;
        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): Provider
    {
        $this->token = $token;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Provider
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed[]
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param mixed[] $config
     */
    public function setConfig(array $config): Provider
    {
        $this->config = $config;
        return $this;
    }

    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }

    public function setCreated(DateTimeImmutable $created): Provider
    {
        $this->created = $created;
        return $this;
    }

    public function getUpdated(): DateTimeImmutable
    {
        return $this->updated;
    }

    public function setUpdated(DateTimeImmutable $updated): Provider
    {
        $this->updated = $updated;
        return $this;
    }

    public function isInUse(): bool
    {
        return $this->inUse;
    }

    public function setInUse(bool $inUse): Provider
    {
        $this->inUse = $inUse;
        return $this;
    }

    public function getCurrentRevisionNumber(): int
    {
        return $this->currentRevisionNumber;
    }

    public function setCurrentRevisionNumber(int $currentRevisionNumber): Provider
    {
        $this->currentRevisionNumber = $currentRevisionNumber;
        return $this;
    }

    /**
     * @return Collection<int,App>
     */
    public function getApps(): Collection
    {
        return $this->apps;
    }
}

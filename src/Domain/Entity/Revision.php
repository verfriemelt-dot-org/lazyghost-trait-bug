<?php

declare(strict_types=1);

namespace sample\Domain\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use sample\Domain\EntityInterface\Trackable;
use sample\Repository\RevisionRepository;
use Symfony\Component\Clock\Clock;
use Override;

/**
 * @final
 */
#[ORM\Entity(repositoryClass: RevisionRepository::class)]
#[ORM\Table(name: 'revision', schema: 'fis')]
#[ORM\UniqueConstraint(name: 'revision_revision_provider_code_idx', columns: ['number', 'provider_code'])]
#[ORM\HasLifecycleCallbacks]
class Revision
{
    #[ORM\Id]
    #[ORM\GeneratedValue('SEQUENCE')]
    #[ORM\Column(name: 'id', type: Types::INTEGER, nullable: false)]
    private int $id;

    #[ORM\Column(name: 'number', type: Types::INTEGER, nullable: false)]
    private int $number;

    #[ORM\ManyToOne(targetEntity: Provider::class)]
    #[ORM\JoinColumn(name: 'provider_code', referencedColumnName: 'code', nullable: false)]
    private Provider $provider;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $created;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updated;

    public function __construct(int $number, Provider $provider)
    {
        $this->created = Clock::get()->now();
        $this->updated = Clock::get()->now();

        $this->number = $number;
        $this->provider = $provider;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getProvider(): Provider
    {
        return $this->provider;
    }

    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }

    public function getUpdated(): DateTimeImmutable
    {
        return $this->updated;
    }

    public function setUpdated(DateTimeImmutable $updated): Revision
    {
        $this->updated = $updated;
        return $this;
    }
}

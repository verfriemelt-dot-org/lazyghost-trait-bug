<?php

declare(strict_types=1);

namespace sample\Domain\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use sample\Domain\EntityInterface\Trackable;
use sample\Repository\RequestCounterRepository;

/**
 * @final
 */
#[ORM\Entity(repositoryClass: RequestCounterRepository::class)]
#[ORM\Table(name: 'request_counter', schema: 'fis')]
#[ORM\HasLifecycleCallbacks]
class RequestCounter
{
    #[ORM\Id]
    #[ORM\GeneratedValue('SEQUENCE')]
    #[ORM\Column(name: 'id', type: Types::INTEGER, nullable: false)]
    private int $id;

    #[ORM\Column(name: 'date', type: Types::DATE_IMMUTABLE)]
    private DateTimeImmutable $date;

    #[ORM\Column(name: 'kind', type: Types::STRING)]
    private string $kind;

    #[ORM\Column(name: 'ref_id', type: Types::INTEGER)]
    private int $refId;

    #[ORM\Column(name: 'count', type: Types::BIGINT)]
    private string $count = '0';

    public function __construct(Trackable $ref, DateTimeImmutable $date)
    {
        $this->refId = $ref->getRefId();
        $this->date = $date;
        $this->kind = $ref->getKind();
    }

    public function increment(): self
    {
        $this->count = (string) (((int) $this->count) + 1);
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCount(): int
    {
        return (int) $this->count;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}

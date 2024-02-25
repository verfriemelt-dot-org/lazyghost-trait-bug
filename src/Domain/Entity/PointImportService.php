<?php

declare(strict_types=1);

namespace sample\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use sample\Repository\PointImportServiceRepository;

/**
 * @final
 */
#[ORM\Entity(repositoryClass: PointImportServiceRepository::class)]
#[ORM\Table(name: 'point_import_service', schema: 'fis')]
class PointImportService
{
    #[ORM\Id]
    #[ORM\GeneratedValue('SEQUENCE')]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    /** @var class-string */
    #[ORM\Column(name: 'class', type: Types::TEXT, nullable: false)]
    private string $class;

    #[ORM\ManyToOne(targetEntity: Provider::class, inversedBy: 'apps')]
    #[ORM\JoinColumn(name: 'provider_code', referencedColumnName: 'code', nullable: false)]
    private Provider $provider;

    /**
     * @param class-string $class
     */
    public function __construct(Provider $provider, string $class)
    {
        $this->provider = $provider;
        $this->class = $class;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProvider(): Provider
    {
        return $this->provider;
    }

    /**
     * @return class-string
     */
    public function getClass(): string
    {
        return $this->class;
    }
}

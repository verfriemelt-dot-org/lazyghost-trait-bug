<?php

declare(strict_types=1);

namespace sample\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use sample\Repository\LineImportServiceRepository;

/**
 * @final
 */
#[ORM\Entity(repositoryClass: LineImportServiceRepository::class)]
#[ORM\Table(name: 'line_import_service', schema: 'fis')]
class LineImportService
{
    #[ORM\Id]
    #[ORM\GeneratedValue('SEQUENCE')]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    /** @var class-string */
    #[ORM\Column(name: 'class', type: Types::TEXT, nullable: false)]
    private string $class;

    /** @var class-string */
    #[ORM\Column(name: 'request_class', type: Types::TEXT, nullable: false)]
    private string $requestClass;

    #[ORM\ManyToOne(targetEntity: Provider::class, inversedBy: 'apps')]
    #[ORM\JoinColumn(name: 'provider_code', referencedColumnName: 'code', nullable: false)]
    private Provider $provider;

    /**
     * @param class-string $class
     * @param class-string $requestClass
     */
    public function __construct(Provider $provider, string $class, string $requestClass)
    {
        $this->provider = $provider;
        $this->class = $class;
        $this->requestClass = $requestClass;
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

    /**
     * @return class-string
     */
    public function getRequestClass(): string
    {
        return $this->requestClass;
    }
}

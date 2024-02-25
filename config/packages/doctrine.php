<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('doctrine', [
        'dbal' => [
            'url' => 'sqlite://nope',
            'use_savepoints' => true,
            'mapping_types' => [
                'geometry' => 'string',
                'geography' => 'string',
                '_text' => 'string',
            ],
            'schema_filter' => '~^(?!tiger|tiger_data|topology|public)~',
        ],
        'orm' => [
            'auto_generate_proxy_classes' => '%kernel.debug%',
            'entity_managers' => [
                'default' => [
                    'auto_mapping' => true,
                    'naming_strategy' => 'doctrine.orm.naming_strategy.underscore_number_aware',
                    'report_fields_where_declared' => true,
                    'mappings' => [
                        'App' => [
                            'is_bundle' => false,
                            'dir' => '%kernel.project_dir%/src/Domain/Entity',
                            'prefix' => 'sample\Domain\Entity',
                        ],
                    ],
                ],
            ],
        ],
    ]);
};

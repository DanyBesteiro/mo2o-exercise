<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('nelmio_api_doc', [
        'documentation' => [
            'info' => [
                'title' => 'mo2o exercise API',
                'description' => 'API endpoint documentation for the mo2o exercise project.',
                'version' => '0.0.1',
            ],
        ],
        'areas' => [
            'default' => [
                'path_patterns' => [
                    '^/books',
                ],
            ],
        ],
    ]);
};

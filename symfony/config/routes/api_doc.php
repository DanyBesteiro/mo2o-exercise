<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $routes->add('api_doc_ui', '/api/doc')
        ->controller('nelmio_api_doc.controller.swagger')
        ->methods(['GET']);

    $routes->add('api_doc_json', '/api/doc.json')
        ->controller('nelmio_api_doc.controller.swagger_json')
        ->methods(['GET']);
};

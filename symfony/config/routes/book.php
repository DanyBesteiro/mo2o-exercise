<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

use App\BoundedContext\Book\Infrastructure\UI\Controller\BookController;

return function (RoutingConfigurator $routes) {

    $routes->add(name: 'get_book', path: '/books/{id}')
        ->methods(['GET'])
        ->controller([BookController::class, 'getBook']);
};

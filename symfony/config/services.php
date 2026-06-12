<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use App\BoundedContext\Book\Infrastructure\Gutendex\API\Client\GutendexClient;

return static function (ContainerConfigurator $configurator) {

    $services = $configurator->services();

    $services->defaults()
        ->autowire(true)
        ->autoconfigure(true);

    $services->load('App\\', '../src/')
        ->exclude('../src/{DependencyInjection,Tools,Kernel.php}');

    $services->set(GutendexClient::class)->args([
        '$gutendexBaseUrl' => '%env(GUTENDEX_BASE_URL)%'
    ]);
};

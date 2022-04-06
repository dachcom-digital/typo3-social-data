<?php

declare(strict_types=1);
namespace DachcomDigital\SocialData;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function(ContainerConfigurator $container, ContainerBuilder $containerBuilder) {
    $containerBuilder->addCompilerPass(new DependencyInjection\ConnectorDefinitionPass());
};

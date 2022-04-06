<?php
declare(strict_types=1);

namespace DachcomDigital\SocialData\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use DachcomDigital\SocialData\Registry\ConnectorDefinitionRegistry;

final class ConnectorDefinitionPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $registryDefinition = $container->findDefinition(ConnectorDefinitionRegistry::class);
        foreach ($container->findTaggedServiceIds('social_data.connector_definition', true) as $id => $tags) {
            $connectorDefinition = $container->getDefinition($id);
            foreach ($tags as $attributes) {
    
                if (!isset($attributes['identifier'])) {
                    throw new InvalidConfigurationException(sprintf('You need to define a valid identifier for connector "%s"', $id));
                } elseif (!isset($attributes['connector'])) {
                    throw new InvalidConfigurationException(sprintf('You need to define a valid connector service for connector "%s"', $id));
                } elseif ($container->hasDefinition($attributes['connector']) === false) {
                    throw new InvalidConfigurationException(sprintf('Connector service "%s" for connector "%s" not found', $attributes['connector'], $id));
                }
    
                $connectorDefinition->addMethodCall('setConnector', [$container->getDefinition($attributes['connector'])]);
                
                $registryDefinition->addMethodCall('register', [new Reference($id), $attributes['identifier']]);
            }
        }
    }
}

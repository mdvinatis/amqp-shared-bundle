<?php

namespace Vinatis\Bundle\AmqpSharedBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 *
 * @author Michel Dourneau <mdourneau@vinatis.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('vinatis_amqp_shared');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->append($this->getMessagesNode())
            ->end();

        return $treeBuilder;
    }

    private function getMessagesNode(): ArrayNodeDefinition
    {
        $treeBuilder = new TreeBuilder('messages');
        $node = $treeBuilder->getRootNode();

        $node
            ->useAttributeAsKey('name')
            ->arrayPrototype()
                ->children()
                    ->scalarNode('class')->end()
                    ->scalarNode('type')->end()
                ->end()
            ->end()
        ;

        return $node;
    }
}

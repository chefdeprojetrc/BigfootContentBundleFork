<?php

namespace Bigfoot\Bundle\ContentBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bigfoot_content');

        $rootNode
            ->children()
                ->arrayNode('templates')
                    ->children()
                        ->arrayNode('page')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('sidebar')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('block')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('widgets')
                    ->isRequired()
                    ->prototype('variable')->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}

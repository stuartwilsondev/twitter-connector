<?php

namespace StuartWilsonDev\TwitterConnectorBundle\DependencyInjection;

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
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('twitter_connector');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
        ->children()
        ->scalarNode('twitter_consumer_key')->isRequired()->cannotBeEmpty()->end()
        ->scalarNode('twitter_consumer_secret')->isRequired()->cannotBeEmpty()->end()
        ->scalarNode('twitter_access_token')->isRequired()->cannotBeEmpty()->end()
        ->scalarNode('twitter_access_secret')->isRequired()->cannotBeEmpty()->end()
        ->end();

        return $treeBuilder;
    }
}

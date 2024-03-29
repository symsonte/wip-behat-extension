<?php

namespace Symsonte\Behat\ServiceContainer;

use Behat\Behat\Context\ServiceContainer\ContextExtension;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symsonte\ServiceKit\PerpetualCachedContainer;

class SymsonteExtension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return 'symsonte';
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('parametersFile')
            ->defaultValue('../../../config/parameters.yml')
            ->end()
            ->scalarNode('cacheDir')
            ->defaultValue('../../../var/cache')
            ->end()
            ->arrayNode('namespaces')
            ->prototype('scalar')->end()
            ->defaultValue([])
            ->end()
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $this->loadContainer($container, $config);
        $this->loadContextInitializer($container);
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function loadContainer(ContainerBuilder $container, $config)
    {
        $definition = new Definition(
            PerpetualCachedContainer::class,
            [
                sprintf('%s/%s', $container->getParameter('paths.base'), $config['parametersFile']),
                [],
                sprintf('%s/%s', $container->getParameter('paths.base'), $config['cacheDir']),
                $config['namespaces'],
            ]
        );
        $container->setDefinition('symsonte.container', $definition);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function loadContextInitializer(ContainerBuilder $container)
    {
        $definition = new Definition('Symsonte\Behat\Context\ContainerAwareInitializer', [
            new Reference('symsonte.container'),
        ]);
        $definition->addTag(ContextExtension::INITIALIZER_TAG, ['priority' => 0]);
        $container->setDefinition('symsonte.behat.context.container_aware_initializer', $definition);
    }
}

<?php

namespace Symsonte\Behat\ServiceContainer;

use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Behat\Behat\Context\ServiceContainer\ContextExtension;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

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
            ->defaultValue(array())
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
            'Symsonte\ServiceKit\Container',
            [
                sprintf("%s/%s", $container->getParameter('paths.base'), $config['parametersFile']),
                sprintf("%s/%s", $container->getParameter('paths.base'), $config['cacheDir']),
                $config['namespaces']
            ]
        );
        $container->setDefinition('symsonte.container', $definition);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function loadContextInitializer(ContainerBuilder $container)
    {
        $definition = new Definition('Symsonte\Behat\Context\ContainerAwareInitializer', array(
            new Reference('symsonte.container'),
        ));
        $definition->addTag(ContextExtension::INITIALIZER_TAG, array('priority' => 0));
        $container->setDefinition('symsonte.behat.context.container_aware_initializer', $definition);
    }
}

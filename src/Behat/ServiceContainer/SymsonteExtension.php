<?php

namespace Symsonte\Behat\ServiceContainer;

use Behat\Behat\Context\ServiceContainer\ContextExtension;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symsonte;

class SymsonteExtension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigKey(): string
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
            ->scalarNode('autoload')
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
    public function load(
        ContainerBuilder $container,
        array $config
    ) {
        $this->loadContainer($container, $config);
        $this->loadContextInitializer($container);
    }

    /**
     * {@inheritdoc}
     */
    public function process(
        ContainerBuilder $container
    ) {
    }

    private function loadContainer(
        ContainerBuilder $container,
        array $config
    ): void {
        $container->setDefinition('symsonte.resolve_pioneer', new Definition(
            Symsonte\ResolvePioneer::class,
            [
                sprintf('%s/../vendor/autoload.php', $container->getParameter('paths.base')),
                $config['namespaces'],
            ]
        ));

        $containerDefinition = new Definition(Symsonte\ResolveService::class);
        $containerDefinition->setFactory([new Reference('symsonte.resolve_pioneer'), 'resolveAsRuntime']);
        $container->setDefinition('symsonte.container', $containerDefinition);
    }

    private function loadContextInitializer(
        ContainerBuilder $container
    ): void {
        $definition = new Definition('Symsonte\Behat\Context\ContainerAwareInitializer', [
            new Reference('symsonte.container'),
        ]);
        $definition->addTag(ContextExtension::INITIALIZER_TAG, ['priority' => 0]);
        $container->setDefinition('symsonte.behat.context.container_aware_initializer', $definition);
    }
}

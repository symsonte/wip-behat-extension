<?php

namespace Symsonte\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Initializer\ContextInitializer;
use Psr\Container\ContainerInterface;
use Symsonte\Behat\ContainerAwareContext;

final class ContainerAwareInitializer implements ContextInitializer
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function initializeContext(Context $context): void
    {
        if (!$context instanceof ContainerAwareContext) {
            return;
        }

        $context->setContainer($this->container);
    }
}

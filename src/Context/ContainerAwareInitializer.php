<?php

namespace Symsonte\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Initializer\ContextInitializer;
use Symsonte\Behat\ContainerAwareContext;
use Symsonte\Service\Container;

final class ContainerAwareInitializer implements ContextInitializer
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function initializeContext(Context $context)
    {
        if (!$context instanceof ContainerAwareContext) {
            return;
        }

        $context->setContainer($this->container);
    }
}
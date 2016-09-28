<?php

namespace Symsonte\Behat;

use Behat\Behat\Context\Context;
use Symsonte\Service\Container;

interface ContainerAwareContext extends Context
{
    /**
     * Sets container instance.
     *
     * @param Container $container
     */
    public function setContainer(Container $container);
}
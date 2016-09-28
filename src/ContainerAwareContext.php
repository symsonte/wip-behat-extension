<?php

namespace Symsonte\Behat;

use Behat\Behat\Context\Context;
use Symsonte\Service\Container;

interface ContainerAwareContext extends Context
{
    /**
     * Sets container instance.
     *
     */
    public function setContainer(Container $container);
}

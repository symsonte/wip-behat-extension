<?php

namespace Symsonte\Behat;

use Behat\Behat\Context\Context;
use Psr\Container\ContainerInterface;

interface ContainerAwareContext extends Context
{
    /**
     * Sets container instance.
     */
    public function setContainer(ContainerInterface $container);
}

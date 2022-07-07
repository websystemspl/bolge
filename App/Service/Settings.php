<?php

namespace Bolge\App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

class Settings implements SettingsInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Get data from yaml settings
     * 
     * @param bool $as_array - return as array (default OBJECT)
     */    
    public function get(bool $as_array = false)
    {
        if(true === $as_array) {
            return $this->container->getParameter('core.settings.array');
        }

        return $this->container->getParameter('core.settings');
    }
}
<?php

namespace Bolge\App\Service;

interface SettingsInterface
{
    /**
     * Get data from yaml settings
     * 
     * @param bool $as_array - return as array (default OBJECT)
     */    
    public function get(bool $as_array = false);
}
<?php

namespace WsLicenseManager\Test\Mock;

use Symfony\Component\Yaml\Yaml;
use WsLicenseManager\App\Service\SettingsInterface;

class SettingsMock implements SettingsInterface
{
    public function get(bool $as_array = false)
    {
        ($as_array === false) ? $type = Yaml::PARSE_OBJECT_FOR_MAP : $type = 0;
        return Yaml::parseFile('config/settings.yaml', $type);
    }
}
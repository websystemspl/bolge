<?php 
declare(strict_types=1);

namespace WsLicenseManager\Test\Unit;

use PHPUnit\Framework\TestCase;
use WsLicenseManager\App\Service\View;
use WsLicenseManager\Test\Mock\SettingsMock;
use WsLicenseManager\Test\Mock\FrameworkMock;

final class ViewTest extends TestCase
{
    public function testCanCreateObject(): void
    {
        $dir = __DIR__;
        $dir = explode("/", $dir);
        foreach($dir as $key => $value) {
            if($value === 'tests') {
                unset($dir[$key]);
            }
            if($value === 'Unit') {
                unset($dir[$key]);
            }
        }
        $dir = implode("/", $dir);


        define('DIR_PATH', $dir);
        
        $view = new View(new SettingsMock, new FrameworkMock); //TODO
        
        $this->assertInstanceOf(
            View::class,
            $view
        );
    }
}



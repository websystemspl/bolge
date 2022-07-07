<?php 
declare(strict_types=1);

namespace WsLicenseManager\Test\Unit\Controller;

use PHPUnit\Framework\TestCase;
use WsLicenseManager\Test\Mock\ViewMock;
use WsLicenseManager\Test\Mock\FrameworkMock;
use Symfony\Component\HttpFoundation\Response;
use WsLicenseManager\Test\Mock\WoocommerceMock;
use WsLicenseManager\App\Controller\Admin\WoocommerceController;

final class WoocommerceControllerTest extends TestCase
{
    public function testIndexActionReturnResponse(): void
    {
        $woocommerceController = new WoocommerceController(
            new ViewMock,
            new FrameworkMock,
            new WoocommerceMock
        );

        $this->assertInstanceOf(
            Response::class,
            $woocommerceController->indexAction()
        );
    }
}

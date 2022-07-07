<?php 
declare(strict_types=1);

namespace WsLicenseManager\Test\Unit;

use WsLicenseManager\App\Service\Mailer;
use PHPUnit\Framework\TestCase;

final class MailerTest extends TestCase
{
    public function testWillReturnString(): void
    {
        $mailer = new Mailer;

        $this->assertEquals(
            '123',
            $mailer->test()
        );
    }
}
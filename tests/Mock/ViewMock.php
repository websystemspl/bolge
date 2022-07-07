<?php

namespace WsLicenseManager\Test\Mock;

use Symfony\Component\HttpFoundation\Response;
use WsLicenseManager\App\Service\ViewInterface;

class ViewMock implements ViewInterface
{
    public function render(string $path, array $params = []): Response
    {
        return new Response();
    }
    
    public function addFlash(string $type, string $message): void
    {

    }
}
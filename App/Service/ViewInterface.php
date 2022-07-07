<?php

namespace Bolge\App\Service;

use Symfony\Component\HttpFoundation\Response;

interface ViewInterface
{ 
    public function render(string $path, array $params = []): Response;
    public function addFlash(string $type, string $message): void;
}

<?php

namespace Bolge\App\Service;

use Symfony\Component\HttpFoundation\Request;

interface OrderingInterface
{
    public function createOrderLinks(Request $request, array $databaseColumns, string $route, int $currentPage): array;
}
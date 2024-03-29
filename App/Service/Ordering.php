<?php

namespace Bolge\App\Service;

use Symfony\Component\HttpFoundation\Request;

class Ordering implements OrderingInterface
{
    public function createOrderLinks(Request $request, array $databaseColumns, string $route, int $currentPage): array
    {
        $links = [];
        foreach($databaseColumns as $databaseColumn) {
            $links[$databaseColumn] = $this->wordpress->getAdminUrlFromRoute($route, [
               'current_page' => $currentPage,
               'order_by' => $databaseColumn,
               'order' => ($request->query->get('order') === 'ASC') ? 'DESC' : 'ASC',
            ]);
        }

        return $links;
    }
}

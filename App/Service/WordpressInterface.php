<?php
declare(strict_types = 1);

namespace Bolge\App\Service;

use Symfony\Component\HttpFoundation\Request;
use Bolge\App\Core\FrameworkInterface;

interface WordpressInterface extends FrameworkInterface
{
    public function __call($function, $arguments);
    public function authenticateCookieLoggedIn(Request $request);
    public function database();
}
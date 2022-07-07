<?php
declare(strict_types = 1);

namespace Bolge\App\Core;

use Bolge\App\Core\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Default controller is for avoid symfony notification
 */
class DefaultController extends Controller
{
    public function defaultAction()
    {
        return new Response();
    }
}

<?php
declare(strict_types = 1);

namespace Bolge\App\Core\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BootEvent extends Event
{
    public const NAME = 'boot.event';

    private Request $request;
    private ?Response $response;

    public function __construct(Request $request, ?Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    public function setResponse(Response $response)
    {
        $this->response = $response;

        return $this;
    }
}
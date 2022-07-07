<?php

namespace Bolge\App\Core\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class HttpKernelRequestEvent extends Event
{
    public const NAME = 'htttpkernelrequest.event';

    private Request $data;

    public function __construct(Request $data)
    {
        $this->data = $data;
    }

    public function getData(): Request
    {
        return $this->data;
    }

    public function setData(Request $data)
    {
        $this->data = $data;
    }    
}
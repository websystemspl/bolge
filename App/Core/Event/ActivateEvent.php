<?php

namespace Bolge\App\Core\Event;

use Symfony\Contracts\EventDispatcher\Event;

class ActivateEvent extends Event
{
    public const NAME = 'activate.event'; 
}
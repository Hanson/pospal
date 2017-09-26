<?php


namespace Hanson\Pospal;


use Hanson\Foundation\Foundation;

/**
 * Class Pospal
 * @package Hanson\Pospal
 *
 * @property \Hanson\Pospal\Ticket\Ticket $ticket
 */
class Pospal extends Foundation
{

    protected $providers = [
        Ticket\ServiceProvider::class,
    ];

}
<?php


namespace Hanson\Pospal;


use Hanson\Foundation\Foundation;

/**
 * Class Pospal
 * @package Hanson\Pospal
 *
 * @property \Hanson\Pospal\Ticket\Ticket $ticket
 * @property \Hanson\Pospal\Customer\Customer $customer
 * @property \Hanson\Pospal\Product\Product $product
 */
class Pospal extends Foundation
{

    protected $providers = [
        Ticket\ServiceProvider::class,
        Customer\ServiceProvider::class,
        Product\ServiceProvider::class,
    ];

}
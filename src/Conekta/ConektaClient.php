<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Conekta;

use Conekta\Conekta;
use Conekta\Order;

class ConektaClient implements IConektaClient
{
    public function __construct(string $apiKey)
    {
        if(is_null($apiKey)) {
            throw new \InvalidArgumentException("The api key is required");
        }
        Conekta::$apiKey = $apiKey;
        Conekta::$plugin = 'Integration Conekta payment into Sylius';
        Conekta::$pluginVersion = '0.0.1';
    }

    public function orderProcess(array $order): Order
    {
        $order = Order::create($order);
        return $order;
    }
}
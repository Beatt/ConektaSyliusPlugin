<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Conekta;

use Conekta\Order;

interface IConektaClient
{
    public function orderProcess(array $order): Order;
}
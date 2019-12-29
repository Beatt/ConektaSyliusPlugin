<?php
declare(strict_types=1);

namespace spec\Lius\SyliusConektaPlugin\Client\Service;

use Lius\SyliusConektaPlugin\Client\Service\OrderConektaService;
use PhpSpec\ObjectBehavior;

class OrderConektaServiceSpec extends ObjectBehavior
{
    function it_order_conekta_service(): void
    {
        $this->shouldHaveType(OrderConektaService::class);
    }
}
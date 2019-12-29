<?php
declare(strict_types=1);

namespace spec\Lius\SyliusConektaPlugin\Client\Service;

use Lius\SyliusConektaPlugin\Client\Service\CustomerConektaService;
use PhpSpec\ObjectBehavior;

class CustomerConektaServiceSpec extends ObjectBehavior
{
    function it_customer_conekta_service(): void
    {
        $this->shouldHaveType(CustomerConektaService::class);
    }
}
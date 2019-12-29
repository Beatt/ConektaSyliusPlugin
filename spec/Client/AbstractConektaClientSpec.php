<?php
declare(strict_types=1);

namespace spec\Lius\SyliusConektaPlugin\Client;

use PhpSpec\ObjectBehavior;

final class AbstractConektaClientSpec extends ObjectBehavior
{
    /*function let(): void
    {
        $this->beAnInstanceOf('Lius\SyliusConektaPlugin\Client\ConektaClient');
    }

    function it_implement_conekta_client_interface(): void
    {
        $this->beConstructedThrough('create', ['apiKey' => 'Api key value']);
        $this->shouldImplement(ConektaClientInterface::class);
    }

    function it_get_customer_conekta_service(ConektaClientInterface $conektaClient): void
    {
        $this->beConstructedThrough('create', ['apiKey' => 'Api key value']);
        $conektaClient->getCustomerConektaService();
        $this->getCustomerConektaService()->shouldReturnAnInstanceOf(CustomerConektaService::class);
    }

    function it_get_order_conekta_service(ConektaClientInterface $conektaClient): void
    {
        $this->beConstructedThrough('create', ['apiKey' => 'Api key value']);
        $conektaClient->getOrderConektaService();
        $this->getOrderConektaService()->shouldReturnAnInstanceOf(OrderConektaService::class);
    }*/
}

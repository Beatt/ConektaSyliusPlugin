<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Payum;

use Lius\SyliusConektaPlugin\Payum\Action\StatusAction;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

class SyliusPaymentGatewayFactory extends GatewayFactory
{
    protected function populateConfig(ArrayObject $config): void
    {
        $config->defaults([
            'payum.factory_name' => 'sylius_payment',
            'payum.factory_title' => 'Sylius payment',
            'payum.action.status' => new StatusAction()
        ]);


        $config['payum.api'] = function(ArrayObject $config) {
            return new SyliusApi($config['api_key']);
        };
    }
}
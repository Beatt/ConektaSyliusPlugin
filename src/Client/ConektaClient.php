<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Client;

use Conekta\Conekta;
use Sylius\Component\Core\Model\PaymentInterface;

class ConektaClient implements ConektaClientInterface
{

    public static function initialize(string $apiKey): self
    {
        Conekta::$apiKey = $apiKey;
        Conekta::$plugin = 'Integration Conekta payment into Sylius';
        Conekta::$pluginVersion = '0.0.1';
        return new ConektaClient();
    }

    public function processCreditCardPayment(
        ProcessorPaymentConektaInterface $processorPaymentConekta,
        PaymentInterface $payment,
        string $creditCardToken
    ) {
        return $processorPaymentConekta->processPayment(
            $payment,
            $creditCardToken
        );
    }
}
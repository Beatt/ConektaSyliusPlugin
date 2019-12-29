<?php
declare(strict_types=1);
namespace Lius\SyliusConektaPlugin\Client;

use Sylius\Component\Core\Model\PaymentInterface;

interface ConektaClientInterface
{
    public function processCreditCardPayment(
        ProcessorPaymentConektaInterface $processorPaymentConekta,
        PaymentInterface $payment,
        string $creditCardToken
    );
}

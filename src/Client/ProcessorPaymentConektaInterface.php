<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Client;

use Sylius\Component\Core\Model\PaymentInterface;

interface ProcessorPaymentConektaInterface
{
    public const CURRENCY = 'MXN';

    public function processPayment(PaymentInterface $payment, string $creditCardToken);
}
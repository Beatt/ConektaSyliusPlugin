<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Entity;

use Sylius\Component\Core\Model\Payment as BasePayment;
use Sylius\Component\Core\Model\PaymentInterface;

class Payment extends BasePayment implements PaymentInterface
{

    private $conektaToken;

    public function getConektaToken(): ?string
    {
        return $this->conektaToken;
    }

    public function setConektaToken(string $conektaToken)
    {
        $this->conektaToken = $conektaToken;
    }
}

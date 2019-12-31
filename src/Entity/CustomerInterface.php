<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Entity;

use Sylius\Component\Core\Model\CustomerInterface as BaseCustomerInterface;

interface CustomerInterface extends BaseCustomerInterface
{
    public function getCustomerIdPaymentGateway(): ?string;
    public function setCustomerIdPaymentGateway(string $customerIdPaymentGateway);
}
<?php
declare(strict_types=1);
namespace Lius\SyliusConektaPlugin\Client\Service;

use Conekta\Customer;
use Sylius\Component\Customer\Context\CustomerContextInterface;

final class CustomerConektaService
{
    private $customerContext;

    public function __construct(CustomerContextInterface $context)
    {
        $this->customerContext = $context->getCustomer();
    }

    public function getConektaCustomer(): Customer
    {
        return Customer::create([
            'name' => $this->customerContext->getFirstName(),
            'email' => $this->customerContext->getEmail(),
            'phone' => $this->customerContext->getPhoneNumber(),
        ]);
    }

    public function updateConektaCustomer(string $id): Customer
    {
        $customer = Customer::find($id);
        return $customer->update([
            'name' => $this->customerContext->getFirstName(),
            'email' => $this->customerContext->getEmail(),
            'phone' => $this->customerContext->getPhoneNumber(),
        ]);
    }
}

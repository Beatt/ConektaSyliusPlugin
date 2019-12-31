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

    public function getConektaCustomerById(?string $id): Customer
    {
        if($id !== null) {
            return $this->updateConektaCustomer($id);
        }

        $customer = Customer::create([
            'name' => $this->customerContext->getFirstName(),
            'email' => $this->customerContext->getEmail(),
            'phone' => $this->customerContext->getPhoneNumber(),
        ]);

        $this->customerContext->setCustomerIdPaymentGateway($customer->id);

        return $customer;
    }

    private function updateConektaCustomer(string $id): Customer
    {
        $customer = Customer::find($id);
        return $customer->update([
            'name' => $this->customerContext->getFirstName(),
            'email' => $this->customerContext->getEmail(),
            'phone' => $this->customerContext->getPhoneNumber(),
        ]);
    }
}

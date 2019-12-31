<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Entity;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Customer as BaseCustomer;

/**
 * @ORM\Table(name="sylius_customer")
 * @ORM\Entity
 */
class Customer extends BaseCustomer implements CustomerInterface
{
    /**
     * @ORM\Column(name="customer_id_payment_gateway", type="string", nullable=true, unique=true)
     */
    private $customerIdPaymentGateway;

    public function getCustomerIdPaymentGateway(): ?string
    {
        return $this->customerIdPaymentGateway;
    }

    public function setCustomerIdPaymentGateway(string $customerIdPaymentGateway)
    {
        $this->customerIdPaymentGateway = $customerIdPaymentGateway;
    }
}
<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Client;

use Conekta\Order;
use Lius\SyliusConektaPlugin\Client\Service\CustomerConektaService;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Customer\Model\CustomerInterface;

class CreditCardProcessorPayment implements ProcessorPaymentConektaInterface
{
    private $customerConektaService;

    public function __construct(CustomerConektaService $customerConektaService)
    {
        $this->customerConektaService = $customerConektaService;
    }

    public function processPayment(PaymentInterface $payment, string $creditCardToken): array
    {
        $response = [];
        $order = ['currency' => self::CURRENCY];

        $this->addCustomer($order, $response, $payment->getOrder()->getCustomer());
        $this->addLineItems($order, $payment);
        $this->addShippingContact($order, $payment);
        $this->addCharge($order, $creditCardToken);

        return $this->commit($order, $response);
    }

    private function addCustomer(array &$order, array &$response, ?CustomerInterface $customer): void
    {
        $customerConekta = $this->customerConektaService->getConektaCustomerById(
            $customer->getCustomerIdPaymentGateway()
        );
        $customerInfo = [];
        $customerInfo['customer_id'] = $customerConekta->id;

        $order['customer_info'] = $customerInfo;
        $response['customerId'] = $customerConekta->id;
    }

    private function addLineItems(array &$order, PaymentInterface $payment): void
    {
        $lineItems = [];
        array_map(function (OrderItemInterface $orderItem) use (&$lineItems) {
            array_push($lineItems, [
                'name' => $orderItem->getProductName(),
                'quantity' => $orderItem->getQuantity(),
                'unit_price' => $orderItem->getUnitPrice(),
            ]);
        }, $payment->getOrder()->getItems()->toArray());

        $order['line_items'] = $lineItems;
    }

    private function addCharge(array &$order, string $creditCardToken): void
    {
        $charge = [];
        array_push($charge, []);
        $this->addPaymentMethod($charge[0], $creditCardToken);
        $order['charges'] = $charge;
    }

    private function addPaymentMethod(array &$charge, string $creditCardToken)
    {
        $paymentMethod = [];
        $paymentMethod['type'] = 'card';
        $paymentMethod['token_id'] = $creditCardToken;
        $charge['payment_method'] = $paymentMethod;
    }

    private function addShippingContact(array &$order, PaymentInterface $payment)
    {
        $shippingContact = [];
        $shippingContact['receiver'] = $payment->getOrder()->getShippingAddress()->getFullName();
        $this->addAddress($shippingContact, $payment);
        $order['shipping_contact'] = $shippingContact;
    }

    private function addAddress(array &$shippingContact, PaymentInterface $payment)
    {
        $address = [];
        $address['street1'] = $payment->getOrder()->getShippingAddress()->getStreet();
        $address['postal_code'] = $payment->getOrder()->getShippingAddress()->getPostcode();
        $address['state'] = $payment->getOrder()->getShippingAddress()->getCity();
        $address['country'] = self::COUNTRY;
        $shippingContact['address'] = $address;
    }

    private function commit(array $order, array $response): array
    {
        $conektaOrder = Order::create($order);
        $this->assignResponseValues($response, $conektaOrder);
        return $response;
    }

    private function assignResponseValues(array &$response, Order $conektaOrder): void
    {
        $response['status'] = $conektaOrder->payment_status;
        $response['orderId'] = $conektaOrder->id;
    }
}
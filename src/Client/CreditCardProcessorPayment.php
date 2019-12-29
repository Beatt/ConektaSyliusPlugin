<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Client;

use Conekta\Order;
use Lius\SyliusConektaPlugin\Client\Service\CustomerConektaService;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\PaymentInterface;

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

        $this->addCustomer($order, $response);
        $this->addLineItems($order, $payment);
        $this->addCharge($order, $creditCardToken);

        return $this->commit($order, $response);
    }

    private function addCustomer(array &$order, array &$response): void
    {
        $customerConekta = $this->customerConektaService->getConektaCustomer();
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
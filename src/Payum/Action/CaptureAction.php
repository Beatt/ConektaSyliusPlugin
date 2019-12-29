<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Payum\Action;

use Conekta\Customer;
use Lius\SyliusConektaPlugin\Client\ConektaClientInterface;
use Lius\SyliusConektaPlugin\Client\CreditCardProcessorPayment;
use Lius\SyliusConektaPlugin\Client\ProcessorPaymentConektaInterface;
use Lius\SyliusConektaPlugin\Entity\PaymentInterface;
use Lius\SyliusConektaPlugin\Payum\ConektaApiClient;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\UnsupportedApiException;
use Sylius\Component\Core\Model\PaymentInterface as SyliusPaymentInterface;
use Payum\Core\Request\Capture;
use Symfony\Component\HttpFoundation\Session\Session;

class CaptureAction implements ActionInterface, ApiAwareInterface
{
    /** @var ConektaClientInterface */
    private $conektaClient;

    private $session;

    private $processorPaymentConekta;

    public function __construct(
        Session $session,
        ProcessorPaymentConektaInterface $processorPaymentConekta
    ) {
        $this->session = $session;
        $this->processorPaymentConekta = $processorPaymentConekta;
    }

    /** @var Capture $request */
    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var PaymentInterface $payment */
        $payment = $request->getModel();

        //$customer = new Customer('cus_2kahYMoono38An8Qs');

        /*$conektaOrder = $this->conektaClient->placeOrder(
            $customer,
            $lineItems,
            [
                [
                    'payment_method' => [
                        'type' => 'card',
                        'token_id' => $this->session->get('conektaToken')
                    ]
                ]
            ]
        );*/

        $result = $this->conektaClient->processCreditCardPayment(
            $this->processorPaymentConekta,
            $payment,
            $this->session->get('conektaToken')
        );

        $payment->setDetails([
            'status' => $result['status'] === 'paid' ? 200 : 400,
            'orderId' => $result['orderId'],
            'customerId' => $result['customerId'],
        ]);
    }

    public function supports($request): bool
    {
        return $request instanceof Capture &&
            $request->getModel() instanceof SyliusPaymentInterface;
    }

    public function setApi($conektaClient): void
    {
        if(!$conektaClient instanceof ConektaApiClient) {
            throw new UnsupportedApiException('Not supported. Expected an instance of ' . ConektaApiClient::class);
        }

        $this->conektaClient = $conektaClient->getClient();
    }
}
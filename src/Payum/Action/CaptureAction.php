<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Payum\Action;

use Lius\SyliusConektaPlugin\Conekta\ConektaClient;
use Lius\SyliusConektaPlugin\Conekta\IConektaClient;
use Lius\SyliusConektaPlugin\Entity\PaymentInterface;
use Lius\SyliusConektaPlugin\Payum\SyliusApi;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\UnsupportedApiException;
use Sylius\Component\Core\Model\PaymentInterface as SyliusPaymentInterface;
use Payum\Core\Request\Capture;

class CaptureAction implements ActionInterface, ApiAwareInterface
{
    /** @var SyliusApi */
    private $api;

    /** @var Capture $request */
    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var PaymentInterface $payment */
        $payment = $request->getModel();

        /** @var IConektaClient $conektaClient */
        $conektaClient = ConektaClient::create($this->api->getApiKey());

        $conektaOrder = $conektaClient->orderProcess([
            'currency' => 'MXN',
            'customer_info' => [
                'customer_id' => 'cus_2kahYMoono38An8Qs'
            ],
            'line_items' => [
                [
                    'name' => 'Box of Cohiba S1s',
                    'unit_price' => $payment->getOrder()->getTotal(),
                    'quantity' => $payment->getOrder()->getTotalQuantity()
                ]
            ],
            'charges' => [
                [
                    'payment_method' => [
                        'type' => 'card',
                        'token_id' => $payment->getCreditCardToken()
                    ]
                ]
            ]
        ]);

        $payment->setDetails(['status' => $conektaOrder->payment_status === 'paid' ? 200 : 400]);
    }

    public function supports($request): bool
    {
        return $request instanceof Capture &&
            $request->getModel() instanceof SyliusPaymentInterface;
    }

    public function setApi($api): void
    {
        if(!$api instanceof SyliusApi) {
            throw new UnsupportedApiException('Not supported. Expected an instance of ' . SyliusApi::class);
        }

        $this->api = $api;
    }
}
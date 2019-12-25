<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Payum\Action;

use Lius\SyliusConektaPlugin\Conekta\IConektaClient;
use Lius\SyliusConektaPlugin\Payum\SyliusApi;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\UnsupportedApiException;
use Sylius\Component\Core\Model\PaymentInterface as SyliusPaymentInterface;
use Payum\Core\Request\Capture;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;


class CaptureAction implements ActionInterface, ApiAwareInterface
{
    private $conektaClient;

    /** @var SyliusApi */
    private $api;

    /** @var Request */
    private $request;

    public function __construct(IConektaClient $conektaClient, RequestStack $request)
    {
        $this->conektaClient = $conektaClient;
        $this->request = $request;
    }

    /** @var Capture $request */
    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var SyliusPaymentInterface $payment */
        $payment = $request->getModel();
        dd($request->get('some'));

        $this->conektaClient->orderProcess([
            'currency' => 'MXN',
            'customer_info' => [
                'customer_id' => 'cus_zzmjKsnM9oacyCwV3'
            ],
            'line_items' => [
                [
                    'name' => 'Box of Cohiba S1s',
                    'unit_price' => $payment->getOrder()->getTotal(),
                    'quantity' => $payment->getAmount()
                ]
            ],
            'charges' => [
                [
                    'payment_method' => [
                        'type' => 'card',
                        'token_id' => $this->api->getApiKey()
                    ]
                ]
            ]
        ]);
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
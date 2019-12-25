<?php


namespace Lius\SyliusConektaPlugin\Service;


use SM\Factory\AbstractFactory;
use Sylius\Component\Order\Context\CartContextInterface;

class CheckoutCompleteService
{
    /**
     * @var CartContextInterface
     */
    private $cartContext;
    /**
     * @var AbstractFactory
     */
    private $factory;

    public function __construct(CartContextInterface $cartContext, AbstractFactory $factory)
    {
        $this->cartContext = $cartContext;
        $this->factory = $factory;
    }

    public function handle()
    {
        $order = $this->cartContext->getCart();

        $stateMachine = $this->factory->get($order, OrderPaymentTransitions::GRAPH);
        $stateMachine->apply(OrderPaymentTransitions::TRANSITION_REQUEST_PAYMENT);
        $stateMachine->apply(OrderPaymentTransitions::TRANSITION_PAY);

        //$this->get('sylius.manager.order')->flush();
    }
}
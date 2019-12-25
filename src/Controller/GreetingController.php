<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Controller;

use Lius\SyliusConektaPlugin\Entity\Payment;
use Sylius\Component\Core\OrderCheckoutTransitions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class GreetingController extends AbstractController
{
    /**
     * @param string|null $name
     *
     * @return Response
     */
    public function staticallyGreetAction(?string $name): Response
    {
        $order = $this->get('sylius.context.cart')->getCart();

        /** @var Payment $payment */
        $payment = $this->get('sylius.repository.payment')->findOneBy(['order' => $order->getId()]);

        $method = $this->get('sylius.repository.payment_method')->find(3);
        $payment->setMethod($method);

        $stateMachineFactory = $this->get('sm.factory');


        // Order payment event
//        $stateMachinePayment = $stateMachineFactory->get($order, OrderPaymentTransitions::GRAPH);
//        $stateMachinePayment->apply(OrderPaymentTransitions::TRANSITION_REQUEST_PAYMENT);
//        $stateMachinePayment->apply(OrderPaymentTransitions::TRANSITION_PAY);


        $stateMachineCheckout = $stateMachineFactory->get($order, OrderCheckoutTransitions::GRAPH);
        $stateMachineCheckout->apply(OrderCheckoutTransitions::TRANSITION_ADDRESS);
        $stateMachineCheckout->apply(OrderCheckoutTransitions::TRANSITION_SELECT_SHIPPING);
        $stateMachineCheckout->apply(OrderCheckoutTransitions::TRANSITION_SELECT_PAYMENT);
        $stateMachineCheckout->apply(OrderCheckoutTransitions::TRANSITION_COMPLETE);


        $this->container->get('sylius.manager.order')->flush();

        return $this->render('@SyliusShop/Order/thankYou.html.twig',
            [
                'order' => $order
            ]
        );
    }

    /**
     * @param string|null $name
     *
     * @return Response
     */
    public function dynamicallyGreetAction(?string $name): Response
    {
        return $this->render('@AcmeSyliusExamplePlugin/dynamic_greeting.html.twig', ['greeting' => $this->getGreeting($name)]);
    }

    /**
     * @param string|null $name
     *
     * @return string
     */
    private function getGreeting(?string $name): string
    {
        switch ($name) {
            case null:
                return 'Hello!';
            case 'Lionel Richie':
                return 'Hello, is it me you\'re looking for?';
            default:
                return sprintf('Hello, %s!', $name);
        }
    }
}

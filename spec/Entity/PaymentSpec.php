<?php
declare(strict_types=1);

use PhpSpec\ObjectBehavior;
use Sylius\Component\Payment\Model\Payment;
use Sylius\Component\Payment\Model\PaymentInterface;

class PaymentSpec extends ObjectBehavior
{
    function it_is_sylius_payment(): void
    {
        $this->shouldHaveType(Payment::class);
    }

    function it_implements_payment_interface(): void
    {
        $this->shouldImplement(PaymentInterface::class);
    }

    function it_can_be_conekta_token(): void
    {
        $this->getConektaToken()->shouldReturn('');

        $this->setConektaToken('token_');
        $this->getConektaToken()->shouldReturn('token_');
    }
}
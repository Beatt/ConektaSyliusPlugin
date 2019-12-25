<?php
declare(strict_types=1);
namespace Lius\SyliusConektaPlugin\Form\Extension;

use Sylius\Bundle\CoreBundle\Form\Type\Checkout\ChangePaymentMethodType;
use Sylius\Bundle\CoreBundle\Form\Type\Checkout\CompleteType;
use Sylius\Bundle\CoreBundle\Form\Type\Checkout\PaymentType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

class CompleteTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('payments', ChangePaymentMethodType::class, [
                'entry_type' => PaymentType::class,
                'label' => false,
            ])
        ;
    }

    public function getExtendedTypes(): iterable
    {
        return [CompleteType::class];
    }
}
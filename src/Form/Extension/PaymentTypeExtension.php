<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Form\Extension;

use Sylius\Bundle\CoreBundle\Form\Type\Checkout\PaymentType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

class PaymentTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    public function getExtendedTypes(): iterable
    {
        return [PaymentType::class];
    }
}
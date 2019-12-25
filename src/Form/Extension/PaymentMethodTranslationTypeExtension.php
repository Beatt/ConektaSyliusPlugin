<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Form\Extension;

use Sylius\Bundle\PaymentBundle\Form\Type\PaymentMethodTranslationType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class PaymentMethodTranslationTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$builder->remove('description');
    }

    public static function getExtendedTypes(): iterable
    {
        return [PaymentMethodTranslationType::class];
    }
}
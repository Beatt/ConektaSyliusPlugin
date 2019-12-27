<?php
declare(strict_types=1);
namespace Lius\SyliusConektaPlugin\Form\Extension;

use Sylius\Bundle\CoreBundle\Form\Type\Checkout\CompleteType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

class CompleteTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    public function getExtendedTypes(): iterable
    {
        return [CompleteType::class];
    }
}
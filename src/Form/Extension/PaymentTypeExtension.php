<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Form\Extension;

use Sylius\Bundle\CoreBundle\Form\Type\Checkout\PaymentType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Session\Session;

class PaymentTypeExtension extends AbstractTypeExtension
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('conektaToken', TextType::class, [
                'mapped' => false
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                $form = $event->getForm();
                $this->session->set('conektaToken', $form->get('conektaToken')->getData());
            })
        ;
    }

    public function getExtendedTypes(): iterable
    {
        return [PaymentType::class];
    }
}
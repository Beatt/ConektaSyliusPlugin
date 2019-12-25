<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CheckoutController extends AbstractController
{
    public function completeAction()
    {
        dd(false);
        return $this->redirectToRoute('home');
    }
}
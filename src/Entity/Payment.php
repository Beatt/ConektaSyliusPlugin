<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Payment as BasePayment;

/**
 * @ORM\Table(name="sylius_payment")
 * @ORM\Entity
 */
class Payment extends BasePayment implements PaymentInterface
{
}
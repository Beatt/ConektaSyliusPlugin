<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Payum;

use Lius\SyliusConektaPlugin\Client\ConektaClientInterface;

final class ConektaApiClient
{
    private $client;

    public function __construct(ConektaClientInterface $client)
    {
        $this->client = $client;
    }

    public function getClient(): ConektaClientInterface
    {
        return $this->client;
    }
}
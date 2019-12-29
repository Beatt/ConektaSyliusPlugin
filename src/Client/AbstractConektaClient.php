<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Client;

use Conekta\Conekta;

abstract class AbstractConektaClient implements ConektaClientInterface
{
    private $apiKey;

    protected function initializeConektaClient()
    {
        if(is_null($this->apiKey) || empty(trim($this->apiKey))) {
            throw new \InvalidArgumentException("The api key is required");
        }
        Conekta::$apiKey = $this->apiKey;
        Conekta::$plugin = 'Integration Conekta payment into Sylius';
        Conekta::$pluginVersion = '0.0.1';
    }

    public function setApiKey($apiKey): void
    {
        $this->apiKey = $apiKey;
    }
}
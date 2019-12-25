<?php
declare(strict_types=1);

namespace Lius\SyliusConektaPlugin\Payum;

final class SyliusApi
{
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}
<?php

namespace ApiRepo\Infrastructre\AkeneoApi;

/**
 * Class AkeneoApiTokenStorage
 * @package ApiRepo\Infrastructre\AkeneoApi
 */
class AkeneoApiTokenStorage
{
    /** @var string */
    private $tokenStoragePath;

    public function __construct(string $tokenStoragePath)
    {
        $this->tokenStoragePath = $tokenStoragePath;
    }

    public function storeTokens(...$tokens): void
    {
        file_put_contents($this->tokenStoragePath, implode('|', $tokens));
    }

    public function hasToken(): bool
    {
        return false !== file_exists($this->tokenStoragePath);
    }

    public function invalidateToken(): void
    {
        unlink($this->tokenStoragePath);
    }

    public function getTokens()
    {
        return explode('|', file_get_contents($this->tokenStoragePath));
    }
}
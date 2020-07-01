<?php

namespace ApiRepo\Infrastructre\AkeneoApi;

use Akeneo\Pim\ApiClient\Api\ProductApiInterface;
use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientBuilder;
use Akeneo\PimEnterprise\ApiClient\AkeneoPimEnterpriseClientInterface;

class AkeneoApiClient
{
    /** @var AkeneoApiAccount */
    private $account;
    /** @var AkeneoPimEnterpriseClientInterface */
    private $client;
    /** @var AkeneoApiTokenStorage */
    private $tokenStorage;

    public function __construct(
        AkeneoApiAccount $account,
        AkeneoApiTokenStorage $tokenStorage
    ) {
        $this->account = $account;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return AkeneoPimEnterpriseClientInterface
     */
    private function getClient(): AkeneoPimEnterpriseClientInterface
    {
        if (null === $this->client) {
            $clientBuilder = new AkeneoPimEnterpriseClientBuilder($this->account->getDomain());

            if (false === $this->tokenStorage->hasToken()) {
                $this->client = $clientBuilder->buildAuthenticatedByPassword(
                    $this->account->getClientId(),
                    $this->account->getSecret(),
                    $this->account->getUsername(),
                    $this->account->getPassword()
                );

                // touch before we can get a token
                $this->client->getCategoryApi()->all(1);
                $this->tokenStorage->storeTokens($this->client->getToken(), $this->client->getRefreshToken());
            }

            list($token, $refreshToken) = $this->tokenStorage->getTokens();

            $this->client = $clientBuilder->buildAuthenticatedByToken(
                $this->account->getClientId(),
                $this->account->getSecret(),
                $token,
                $refreshToken
            );
            $this->account = null;
        }

        return $this->client;
    }

    public function __destruct()
    {
        $this->client = null;
    }

    public function clear(): void
    {
        $this->tokenStorage->invalidateToken();
        $this->__destruct();
    }

    public function getProductApi(): ProductApiInterface
    {
        return $this->client->getProductApi();
    }
}
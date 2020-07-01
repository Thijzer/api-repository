<?php

namespace ApiRepo\Infrastructre\AkeneoApi;

class AkeneoApiAccount
{
    /** @var string */
    private $clientId;
    /** @var string */
    private $secret;
    /** @var string */
    private $username;
    /** @var string */
    private $password;
    /** @var string */
    private $domain;

    public function __construct(string $clientId, string $secret, string $username, string $password, string $domain)
    {
        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->username = $username;
        $this->password = $password;
        $this->domain = $domain;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }
}
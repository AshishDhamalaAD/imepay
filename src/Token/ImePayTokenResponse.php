<?php

namespace Asdh\ImePay\Token;

class ImePayTokenResponse
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function raw(): array
    {
        return $this->data;
    }

    public function responseCode(): int
    {
        return $this->data['ResponseCode'];
    }

    public function tokenId(): string
    {
        return $this->data['TokenId'];
    }

    public function amount(): string
    {
        return $this->data['Amount'];
    }

    public function refId(): string
    {
        return $this->data['RefId'];
    }

    public function responseDescription(): ?string
    {
        return $this->data['ResponseDescription'];
    }
}

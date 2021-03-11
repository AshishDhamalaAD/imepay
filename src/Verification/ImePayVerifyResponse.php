<?php

namespace Asdh\ImePay\Verification;

class ImePayVerifyResponse
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

    public function refId(): string
    {
        return $this->data['RefId'];
    }

    public function msisdn(): string
    {
        return $this->data['Msisdn'];
    }

    public function tokenId(): string
    {
        return $this->data['TokenId'];
    }

    public function responseCode(): int
    {
        return $this->data['ResponseCode'];
    }

    public function transactionId(): string
    {
        return $this->data['TransactionId'];
    }

    public function responseDescription(): ?string
    {
        return $this->data['ResponseDescription'];
    }

    public function isVerified(): bool
    {
        return $this->responseCode() === 0;
    }

    public function isNotVerified(): bool
    {
        return ! $this->isVerified();
    }
}

<?php

namespace Asdh\ImePay\Verification;

class ImePayVerifyRequestData
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function responseCode(): int
    {
        return $this->data['ResponseCode'];
    }

    public function responseDescription(): ?string
    {
        return $this->data['ResponseDescription'];
    }

    public function refId(): string
    {
        return $this->data['RefId'];
    }

    public function transactionAmount(): string
    {
        return $this->data['TranAmount'];
    }

    public function msisdn(): string
    {
        return $this->data['Msisdn'];
    }

    public function transactionId(): string
    {
        return $this->data['TransactionId'];
    }

    public function tokenId(): string
    {
        return $this->data['TokenId'];
    }
}

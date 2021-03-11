<?php

namespace Asdh\ImePay;

use Asdh\ImePay\Exceptions\ImePayException;
use Exception;
use Illuminate\Support\Facades\Http;

class ImePayToken
{
    private $refId;

    private $amount;

    public function __construct(string $refId, $amount)
    {
        $this->refId = $refId;
        $this->amount = $amount;
    }

    private function url(): string
    {
        return config('imepay.base_url') . '/api/Web/GetToken';
    }

    public function get(): ImePayTokenResponse
    {
        try {
            $response = Http::withBasicAuth(config('imepay.username'), config('imepay.password'))
                ->withHeaders([
                    'Module' => base64_encode(config('imepay.merchant_module')),
                ])
                ->post($this->url(), [
                    'MerchantCode' => config('imepay.merchant_code'),
                    'Amount' => $this->amount,
                    'RefId' => $this->refId,
                ])
                ->throw();
        } catch (Exception $exception) {
            throw new ImePayException((new ImePayErrorMessage($exception))->get(), $exception->getCode());
        }

        return new ImePayTokenResponse($response->json());
    }
}

<?php

namespace Asdh\ImePay\Verification;

use Asdh\ImePay\Exceptions\ImePayException;
use Asdh\ImePay\ImePayErrorMessage;
use Exception;
use Illuminate\Support\Facades\Http;

class ImePayVerify
{
    private $request;

    public function __construct(ImePayVerifyRequestData $request)
    {
        $this->request = $request;
    }

    public function url(): string
    {
        return config('imepay.base_url') . '/api/Web/Confirm';
    }

    public function verify(): ImePayVerifyResponse
    {
        try {
            $response = Http::withBasicAuth(config('imepay.username'), config('imepay.password'))
                ->withHeaders([
                    'Module' => base64_encode(config('imepay.merchant_module')),
                ])
                ->post($this->url(), [
                    'MerchantCode' => config('imepay.merchant_code'),
                    'RefId' => $this->request->refId(),
                    'TokenId' => $this->request->tokenId(),
                    'TransactionId' => $this->request->transactionId(),
                    'Msisdn' => $this->request->msisdn(),
                ])
                ->throw();
        } catch (Exception $exception) {
            throw new ImePayException((new ImePayErrorMessage($exception))->get(), (int) $exception->getCode());
        }

        return new ImePayVerifyResponse($response->json());
    }
}

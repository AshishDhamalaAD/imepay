<?php

namespace Asdh\ImePay\Tests;

use Asdh\ImePay\Exceptions\ImePayException;
use Asdh\ImePay\ImePay;
use Asdh\ImePay\ImePayErrorMessage;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ImePayTokenTest extends TestCase
{
    /** @test */
    public function can_get_token_if_everything_is_correct()
    {
        $refId = '3510967d-3a98-4b61-a74b-974c6e953991';
        $amount = number_format(100, 4, '.', '');

        Http::fakeSequence()->pushResponse(Http::response([
            'ResponseCode' => 0,
            'TokenId' => '202103111046564183',
            'Amount' => $amount,
            'RefId' => $refId,
            'ResponseDescription' => null,
        ]));

        $imePay = new ImePay();
        $response = $imePay->getToken($refId, $amount);

        $json = $response->raw();

        $this->assertIsArray($json);
        $this->assertArrayHasKey('ResponseCode', $json);
        $this->assertArrayHasKey('ResponseDescription', $json);
        $this->assertArrayHasKey('TokenId', $json);
        $this->assertArrayHasKey('Amount', $json);
        $this->assertArrayHasKey('RefId', $json);

        $this->assertEquals($response->amount(), $amount);
        $this->assertEquals($response->refId(), $refId);
    }

    /** @test */
    public function cannot_get_token_for_wrong_credentials()
    {
        $this->expectException(ImePayException::class);
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);
        $this->expectErrorMessage(ImePayErrorMessage::UNAUTHORIZED);

        $refId = '3510967d-3a98-4b61-a74b-974c6e953991';
        $price = number_format(100, 4, '.', '');
        config()->set('imepay.username', 'apple');

        Http::fakeSequence()
            ->whenEmpty(function () {
                throw new ImePayException(ImePayErrorMessage::UNAUTHORIZED, Response::HTTP_UNAUTHORIZED);
            });

        $imePay = new ImePay();
        $imePay->getToken($refId, $price);
    }
}

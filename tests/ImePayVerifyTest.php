<?php

namespace Asdh\ImePay\Tests;

use Asdh\ImePay\Exceptions\ImePayException;
use Asdh\ImePay\ImePay;
use Asdh\ImePay\ImePayErrorMessage;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ImePayVerifyTest extends TestCase
{
    /** @test */
    public function is_verified_if_all_data_is_valid()
    {
        config()->set('imepay.username', 'apple');
        config()->set('imepay.password', 'ball');

        $refId = 'a460c09b-7783-47b6-b3a6-2d15cab71ed7';
        $phone = '9840594104';

        $requestData = [
            "RefId" => $refId,
            "Msisdn" => $phone,
            "TokenId" => "202103091150034061",
            "TranAmount" => "20.0000",
            "ResponseCode" => "0",
            "TransactionId" => "202103091150349847",
            "ResponseDescription" => "Success",
        ];

        Http::fakeSequence()->pushResponse(Http::response([
            "RefId" => $refId,
            "Msisdn" => $phone,
            "TokenId" => "202103091150034061",
            "ResponseCode" => 0,
            "TransactionId" => "202103091150349847",
            "ResponseDescription" => "Success",
        ]));

        $imePay = new ImePay();
        $response = $imePay->verify($requestData);

        $json = $response->raw();

        $this->assertIsArray($json);
        $this->assertArrayHasKey('RefId', $json);
        $this->assertEquals($requestData['RefId'], $json['RefId']);
        $this->assertArrayHasKey('Msisdn', $json);
        $this->assertEquals($requestData['Msisdn'], $json['Msisdn']);
        $this->assertArrayHasKey('TokenId', $json);
        $this->assertEquals($requestData['TokenId'], $json['TokenId']);
        $this->assertArrayHasKey('ResponseCode', $json);
        $this->assertEquals(0, $json['ResponseCode']);
        $this->assertArrayHasKey('TransactionId', $json);
        $this->assertEquals($requestData['TransactionId'], $json['TransactionId']);
        $this->assertArrayHasKey('ResponseDescription', $json);
        $this->assertTrue($response->isVerified());
    }

    /** @test */
    public function transaction_is_not_found_if_transaction_id_does_not_match()
    {
        config()->set('imepay.username', 'apple');
        config()->set('imepay.password', 'ball');

        $refId = 'a460c09b-7783-47b6-b3a6-2d15cab71ed7';
        $phone = '9840000000';

        $requestData = [
            "RefId" => $refId,
            "Msisdn" => $phone,
            "TokenId" => "202103091150034061",
            "TranAmount" => "20.0000",
            "ResponseCode" => "0",
            "TransactionId" => "2021030911503498470",
            "ResponseDescription" => "Success",
        ];

        Http::fakeSequence()->pushResponse(Http::response([
            "RefId" => $refId,
            "Msisdn" => $phone,
            "TokenId" => "202103091150034061",
            "ResponseCode" => 1,
            "TransactionId" => "2021030911503498470",
            "ResponseDescription" => "Transaction Not Found",
        ]));

        $imePay = new ImePay();
        $response = $imePay->verify($requestData);

        $json = $response->raw();

        $this->assertIsArray($json);
        $this->assertArrayHasKey('RefId', $json);
        $this->assertEquals($requestData['RefId'], $json['RefId']);
        $this->assertArrayHasKey('Msisdn', $json);
        $this->assertEquals($requestData['Msisdn'], $json['Msisdn']);
        $this->assertArrayHasKey('TokenId', $json);
        $this->assertEquals($requestData['TokenId'], $json['TokenId']);
        $this->assertArrayHasKey('ResponseCode', $json);
        $this->assertEquals(1, $json['ResponseCode']);
        $this->assertArrayHasKey('TransactionId', $json);
        $this->assertArrayHasKey('ResponseDescription', $json);
        $this->assertEquals('Transaction Not Found', $json['ResponseDescription']);
        $this->assertFalse($response->isVerified());
    }

    /** @test */
    public function is_unauthorize_if_data_is_invalid()
    {
        $this->expectException(ImePayException::class);
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);
        $this->expectErrorMessage(ImePayErrorMessage::UNAUTHORIZED);

        config()->set('imepay.username', 'apple');
        config()->set('imepay.password', 'ball');

        $responseData = [
            "RefId" => "3510967d-3a98-4b61-a74b-974c6e953991",
            "Msisdn" => "9841000000",
            "TokenId" => "202103091150034061",
            "TranAmount" => "10.0000",
            "ResponseCode" => "0",
            "TransactionId" => "202103091150349847",
            "ResponseDescription" => "Success"
        ];

        Http::fakeSequence()
            ->whenEmpty(function () {
                throw new ImePayException(ImePayErrorMessage::UNAUTHORIZED, Response::HTTP_UNAUTHORIZED);
            });

        $imePay = new ImePay();
        $imePay->verify($responseData);
    }
}

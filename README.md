# IME Pay payment validation package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/asdh/imepay.svg?style=flat-square)](https://packagist.org/packages/asdh/imepay)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/asdh/imepay/run-tests?label=tests)](https://github.com/asdh/imepay/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/asdh/imepay/Check%20&%20fix%20styling?label=code%20style)](https://github.com/asdh/imepay/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/asdh/imepay.svg?style=flat-square)](https://packagist.org/packages/asdh/imepay)

A very small package to inetgrate IME Pay in your laravel project.

## Installation

You can install the package via composer:

```bash
composer require asdh/imepay
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Asdh\ImePay\ImePayServiceProvider" --tag="imepay-config"
```

This is the contents of the published config file:

```php
return [
    'merchant_number' => env('IME_PAY_MERCHANT_NUMBER'),
    'merchant_name' => env('IME_PAY_MERCHANT_NAME'),
    'merchant_code' => env('IME_PAY_MERCHANT_CODE'),
    'merchant_module' => env('IME_PAY_MERCHANT_MODULE'),
    'username' => env('IME_PAY_USERNAME'),
    'password' => env('IME_PAY_PASSWORD'),
    /**
     * The payment url
     *
     * E.g. https://stg.imepay.com.np:1234
     */
    'base_url' => env('IME_PAY_BASE_URL'),
];
```

## Usage

### Getting token for payment

To get the token before initiating the payment:

```php
$imepay = new Asdh\ImePay();

$refId = Str::uuid();
$amount = 100;

$response = $imepay->getToken($refId, $amount);

$token = $response->tokenId();
```

There are also other methods in the above `$response` instance. All these methods represent the response from the IME Pay itself.

```php
$response->responseCode();
$response->responseDescription();
$response->refId();
$response->tokenId();
$response->amount();
```

To get the raw response from IME Pay:

```php
$response->raw();
```

Also, if the credentials you provided was not correct, it will throw `ImePayException`. You can catch this exception and perform your action.

### Verifying the payment

When a user pays using IME Pay in your website, IME Pay will redirect to a success url that you have to provide. In that url they will send a post request with some parameters.

You can verify if it is valid like shown in the below code.

First of all in your controller do this:

```php
$imepay = new Asdh\ImePay();

$response = $imepay->verify($request->all());

if ($response->isVerified()) {
    // do your stuffs...
}
```

There is also `$response->isNotVerified()` method which could be useful. If the response is not verified, you can get the message using `$response->responseDescription()`.

There are also other methods in the above `$response` instance. All these methods represent the response from the IME Pay itself.

```php
$response->responseCode();
$response->responseDescription();
$response->refId();
$response->msisdn(); // phone number of paying user
$response->tokenId();
$response->transactionId();
```

To get the raw response from IME Pay:

```php
$response->raw();
```

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Ashish Dhamala](https://github.com/AshishDhamala)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

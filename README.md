<p align="center">
  <img src="https://expresspaygh.com/images/logo.png" />
</p>
<br/>

# Expresspay PHP SDK

A simple library for PHP integrators

------------------

# Install

* Install composer for your environment - (Composer)[https://getcomposer.org/download/]
* Import package via composer using the command below
```php
composer require expresspaygh/exp-php-sdk
```

-------------------

# Demo / Test

* Browser Demo: [https://github.com/expresspaygh/exp-demos/tree/master/exp-php-sdk-demo]
* Unit Test: `make phpunit` or `composer run test`

-------------------

# How to use

## Allowed Environments

* Sandbox - "sandbox"
* Production - "production"

-------------------

## Submit request

This request creates a new invoice to process a payment, below you will find an example request and response.

```php
require_once('./vendor/autoload.php');

use Expay\SDK\MerchantApi as ExpressPayMerchantApi;

/**
 * $this->merchant_id = Your expressPay merchant id
 * $this->merchant_key = Your expressPay merchant api key
 * $this->environment = Your preferred environment, allowed params ('sandbox' or 'production')
 */
$merchantApi = new ExpressPayMerchantApi($this->merchant_id, $this->merchant_key, $this->environment);

/**
 * submit
 *
 * string $currency
 * float $amount
 * string $order_id
 * string $order_desc
 * string $redirect_url
 * string $account_number
 * string | null $order_img_url
 * string | null $first_name
 * string | null $last_name
 * string | null $phone_number
 * string | null $email
 */
$response = $merchantApi->submit(
  "GHS",
  20.00,
  "0925469924813",
  "Test create invoice",
  "https://expresspaygh.com",
  "1234567890",
  "https://expresspaygh.com/images/logo.png",
  "Jeffery",
  "Osei",
  "233545512042",
  "jefferyosei@expresspaygh.com"
);

// print
var_dump($response);
```

```
array(13) {
  ["status"]=> int(1)
  ["order-id"]=> string(13) "0925469924813"
  ["guest-checkout"]=> string(4) "TRUE"
  ["merchantservice-name"]=> string(3) "TEST"
  ["merchantservice-srvrtid"]=> string(12) "089908783876"
  ["message"]=> string(7) "Success"
  ["token"]=> string(64) "43165f2bcf90eef856.514313495f2bcf90eef8b1.85035432516432mjhyte"
  ["redirect-url"]=> string(24) "https://expresspaygh.com"
  ["user-key"]=> NULL
  ["merchant-name"]=> string(3) "TEST"
  ["merchant-mcc"]=> string(4) "1234"
  ["merchant-city"]=> string(5) "Accra"
  ["merchant-countrycode"]=> string(2) "GH"
}
```

--------------------

## Checkout request

This request creates a checkout url for a customer to make payment on expressPay, below you will find an example request and response.

```php
require_once('./vendor/autoload.php');

use Expay\SDK\MerchantApi as ExpressPayMerchantApi;

/**
 * $this->merchant_id = Your expressPay merchant id
 * $this->merchant_key = Your expressPay merchant api key
 * $this->environment = Your preferred environment, allowed params ('sandbox' or 'production')
 */
$merchantApi = new ExpressPayMerchantApi($this->merchant_id, $this->merchant_key, $this->environment);

/*
* Token returned from your "Submit" request
*/
$token = "43165f2bcf90eef856.514313495f2bcf90eef8b1.85035432516432mjhyte";

/**
 * checkout
 *
 * string $token
 */
$response = $merchantApi->checkout($token);

// print
var_dump($response);
```

```
<!-- The checkout url is based on your selected environment -->
string(120) "https://sandbox.expresspaygh.com/api/checkout.php?token=43165f2bcf90eef856.514313495f2bcf90eef8b1.85035432516432mjhyte"
```

-------------------

## Query request - Before payment

This request checks the payment status for an invoice on expressPay, below you will find an example request and response for 
an unpaid invoice.

```php
require_once('./vendor/autoload.php');

use Expay\SDK\MerchantApi as ExpressPayMerchantApi;

/**
 * $this->merchant_id = Your expressPay merchant id
 * $this->merchant_key = Your expressPay merchant api key
 * $this->environment = Your preferred environment, allowed params ('sandbox' or 'production')
 */
$merchantApi = new ExpressPayMerchantApi($this->merchant_id, $this->merchant_key, $this->environment);

/*
* Token returned from your "Submit" request
*/
$token = "43165f2bcf90eef856.514313495f2bcf90eef8b1.85035432516432mjhyte";

/**
 * checkout
 *
 * string $token
 */
$response = $merchantApi->query($token);

// print
var_dump($response);
```

```
array(6) {
  ["result"]=> int(3)
  ["result-text"]=> string(29) "No transaction data available"
  ["order-id"]=> string(13) "0925469924813"
  ["token"]=> string(64) "43165f2bcf90eef856.514313495f2bcf90eef8b1.85035432516432mjhyte"
  ["currency"]=> string(3) "GHS"
  ["amount"]=> string(2) "20"
}
```

-------------------

## Query request - After payment

This request checks the payment status for an invoice on expressPay, below you will find an example request and response for 
a paid invoice.

```php
require_once('./vendor/autoload.php');

use Expay\SDK\MerchantApi as ExpressPayMerchantApi;

/**
 * $this->merchant_id = Your expressPay merchant id
 * $this->merchant_key = Your expressPay merchant api key
 * $this->environment = Your preferred environment, allowed params ('sandbox' or 'production')
 */
$merchantApi = new ExpressPayMerchantApi($this->merchant_id, $this->merchant_key, $this->environment);

/*
* Token returned from your "Submit" request
*/
$token = "43165f2bcf90eef856.514313495f2bcf90eef8b1.85035432516432mjhyte";

/**
 * checkout
 *
 * string $token
 */
$response = $merchantApi->query($token);

// print
var_dump($response);
```

```
array(15) {
  ["result"]=> int(1)
  ["result-text"]=> string(7) "Success"
  ["order-id"]=> string(13) "0925469924813"
  ["token"]=> string(64) "43165f2bcf90eef856.514313495f2bcf90eef8b1.85035432516432mjhyte"
  ["currency"]=> string(3) "GHS"
  ["amount"]=> string(2) "20"
  ["auth-code"]=> string(6) "831000"
  ["transaction-id"]=> string(13) "030556c7x8c56"
  ["date-processed"]=> string(19) "2020-08-06 11:36:16"
  ["paid_from"]=> string(16) "411111******1111"
  ["payment_type"]=> string(7) "XPAY_GW"
  ["payment_reference"]=> string(6) "831000"
  ["payment_option"]=> string(4) "VISA"
  ["payment_option_type"]=> string(7) "CARDNET"
  ["payment_option_type_name"]=> string(34) "Visa, Mastercard, Amex or Discover"
}
```

----------------------

Copyright 2020, All rights reserved. Expresspay Ghana Limited [https://expresspaygh.com]

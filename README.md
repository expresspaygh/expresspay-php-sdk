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

This request creates a new invoice to process a payment with, below you will find a test request and response.

```php
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


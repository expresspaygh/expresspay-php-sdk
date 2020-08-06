# Expresspay PHP SDK
A simple library for PHP integrators

------------------

# Install
```php
composer require expresspaygh/exp-php-sdk
```

-------------------

# Demo / Test
[https://github.com/expresspaygh/exp-demos]

-------------------

# How to use

## Submit request
This request creates a new invoice to process a payment with, below you will find a test request and response.

```php
use Expay\SDK\MerchantApi;

$merchantApi = new MerchantApi($this->merchant_id, $this->merchant_key, $this->environment);

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


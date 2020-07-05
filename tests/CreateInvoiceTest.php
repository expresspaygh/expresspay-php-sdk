<?php

use Faker\Factory;
use Expay\SDK\Utility\Config;
use PHPUnit\Framework\TestCase;
use Expay\SDK\Exceptions\BadRequest;
use Expay\SDK\Requests\CreateInvoice;

/**
 * CreateInvoiceTest
 */
class CreateInvoiceTest extends TestCase
{
  /**
   * faker
   *
   * @var mixed
   */
  private $faker;  
  /**
   * config
   *
   * @var mixed
   */
  private $config;

  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
    $this->faker=Factory::create();
    $this->config = new Config("121", "VYYG9HyJhf4Bfzv6qGUx");
  }
    
  /**
   * testCleanCreateInvoiceRequest
   *
   * @return void
   */
  public function testCleanCreateInvoiceRequest()
  {
    $request = [
      "order_id" => $this->faker->ean13,
      "currency" => "GHS",
      "amount" => round($this->faker->randomFloat, 2),
      "account_number" => $this->faker->isbn13,
      "order_desc" => $this->faker->sentence,
      "account_name" => $this->faker->name,
      "phone_number" => $this->faker->e164PhoneNumber,
      "email" => $this->faker->freeEmail,
      "redirect_url" => $this->faker->url
    ];

    $createInvoice = new CreateInvoice($request, $this->config);
    $result = $createInvoice->make()->toArray();

    $this->assertIsArray($result);
    $this->assertTrue(!empty($result));
    $this->assertCount(13, $result);
  }

  /**
   * testCreateInvoiceNoRequest
   *
   * @return void
   */
  public function testCreateInvoiceNoRequest()
  {
    try {
      $createInvoice = new CreateInvoice([], $this->config);
      $createInvoice->make()->toArray();
    } catch(BadRequest $e) {
      $this->assertEquals($e->getMessage(), "Sorry, request cannot be empty");
    }
  }
}

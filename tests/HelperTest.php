<?php

use Faker\Factory;
use Expay\SDK\Utility\Helpers;
use PHPUnit\Framework\TestCase;

/**
 * HelperTest
 */
class HelperTest extends TestCase
{
  /**
   * faker
   *
   * @var mixed
   */
  private $faker;

  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
    $this->faker=Factory::create();
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

    $helper = new Helpers($request);
    $helper = $helper->clean_create_invoice_request();

    $this->assertIsObject($helper);
    $this->assertIsArray($helper->output);
    $this->assertObjectHasAttribute('status', $helper);
    $this->assertObjectHasAttribute('message', $helper);
    $this->assertTrue(!empty($helper->output));
    $this->assertCount(9, $helper->output);
  }
  
  /**
   * testCleanSubmitRequest
   *
   * @return void
   */
  public function testCleanSubmitRequest()
  {
    $request = [
      "currency" => "GHS",
      "amount" => round($this->faker->randomFloat, 2),
      "order_id" => $this->faker->ean13,
      "order_desc" => $this->faker->sentence,
      "redirect_url" => $this->faker->url,
      "account_number" => $this->faker->isbn13,
      "order_img_url" => $this->faker->imageUrl,
      "first_name" => $this->faker->firstName,
      "last_name" => $this->faker->lastName,
      "phone_number" => $this->faker->e164PhoneNumber,
      "email" => $this->faker->freeEmail
    ];

    $helper = new Helpers($request);
    $helper = $helper->clean_submit_request();

    $this->assertIsObject($helper);
    $this->assertIsArray($helper->output);
    $this->assertObjectHasAttribute('status', $helper);
    $this->assertObjectHasAttribute('message', $helper);
    $this->assertTrue(!empty($helper->output));
    $this->assertCount(11, $helper->output);
  }
  
  /**
   * testCleanCheckoutRequest
   *
   * @return void
   */
  public function testCleanCheckoutRequest()
  {
    $request = [
      "token" => $this->faker->uuid
    ];

    $helper = new Helpers($request);
    $helper = $helper->clean_checkout_request();

    $this->assertIsObject($helper);
    $this->assertIsArray($helper->output);
    $this->assertObjectHasAttribute('status', $helper);
    $this->assertObjectHasAttribute('message', $helper);
    $this->assertTrue(!empty($helper->output));
    $this->assertCount(1, $helper->output);
  }
  
  /**
   * testCleanQueryRequest
   *
   * @return void
   */
  public function testCleanQueryRequest()
  {
    $request = [
      "token" => $this->faker->uuid
    ];

    $helper = new Helpers($request);
    $helper = $helper->clean_query_request();

    $this->assertIsObject($helper);
    $this->assertIsArray($helper->output);
    $this->assertObjectHasAttribute('status', $helper);
    $this->assertObjectHasAttribute('message', $helper);
    $this->assertTrue(!empty($helper->output));
    $this->assertCount(1, $helper->output);
  }
}

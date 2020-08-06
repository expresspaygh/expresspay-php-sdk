<?php

use Faker\Factory;
use Expay\SDK\MerchantApi;
use PHPUnit\Framework\TestCase;

/**
 * MerchantApiTest
 */
class MerchantApiTest extends TestCase
{
  /**
   * faker
   *
   * @var mixed
   */
  private $faker;
  /**
   * redirect_url
   *
   * @var string
   */
  private $redirect_url = "";  
  /**
   * order_img_url
   *
   * @var string
   */
  private $order_img_url = "";
  /**
   * merchant_id
   *
   * @var string
   */
  private $merchant_id = "";  
  /**
   * merchant_key
   *
   * @var string
   */
  private $merchant_key = "";   
  /**
   * environment
   *
   * @var string
   */
  private $environment = "";  

  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();

    $this->faker = Factory::create();

    $this->redirect_url = "https://expresspaygh.com";
    $this->order_img_url = "https://expresspaygh.com/images/logo.png";

    $this->environment = "sandbox";
    $this->merchant_id = "089237783227";
    $this->merchant_key = "JKR91Vs1zEcuAj9LwMXQu-H3LPrDq1XCKItTKpmLY1-XsBgCnNpkDT1GER8ih9f-UTYoNINatMbreNIRavgu-89wPOnY6F7mz1lXP3LZ";
  }

  /**
   * init reference method to store expresspay token for re-use in test
   */
  protected function &getToken()
  {
    static $token = null;
    return $token;
  }
  
  /**
   * setUp
   *
   * @return void
   */
  public function setUp() : void
  {
    parent::setUp();
  }
  
  /**
   * tearDown
   *
   * @return void
   */
  public function tearDown(): void 
  {
    parent::tearDown();
  }
    
  /**
   * testSubmitRequest
   *
   * @return void
   */
  public function testSubmitRequest() : void
  {
    $merchantApi = new MerchantApi($this->merchant_id, $this->merchant_key, $this->environment);

    $order_id = $this->faker->ean13;

    $response = $merchantApi->submit(
      "GHS",
      20.00,
      $order_id,
      "Test create invoice",
      $this->redirect_url,
      "1234567890",
      $this->order_img_url,
      "Jeffery",
      "Osei",
      "233545512042",
      "jefferyosei@expresspaygh.com"
    );

    $token = &$this->getToken();
    $token = $response['token'];

    $this->assertIsArray($response);
    $this->assertTrue(!empty($response));
    $this->assertEquals($response['status'], 1);
    $this->assertArrayHasKey('token', $response);
    $this->assertArrayHasKey('status', $response);
    $this->assertArrayHasKey('message', $response);
    $this->assertArrayHasKey('order-id', $response);
    $this->assertEquals($response['message'], 'Success');
    $this->assertEquals($response['order-id'], $order_id);
  }
  
  /**
   * testCheckoutRequest
   *
   * @return void
   */
  public function testCheckoutRequest() : void
  {
    $merchantApi = new MerchantApi($this->merchant_id, $this->merchant_key, $this->environment);
 
    $token = &$this->getToken();

    $response = $merchantApi->checkout($token);

    $this->assertIsString($response);
    $this->assertTrue(!empty($response));
  }

  /**
   * testQueryRequest
   *
   * @return void
   */
  public function testQueryRequest() : void
  {
    $merchantApi = new MerchantApi($this->merchant_id, $this->merchant_key, $this->environment);
 
    $token = &$this->getToken();

    $response = $merchantApi->query($token);

    $this->assertIsArray($response);
    $this->assertTrue(!empty($response));
    $this->assertArrayHasKey('token', $response);
    $this->assertArrayHasKey('amount', $response);
    $this->assertArrayHasKey('order-id', $response);
    $this->assertArrayHasKey('currency', $response);
    $this->assertEquals($response['token'], $token);
  }
}

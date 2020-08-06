<?php

use Expay\SDK\Utility\Config;
use PHPUnit\Framework\TestCase;

/**
 * ConfigTest
 */
class ConfigTest extends TestCase
{
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
    
    $this->config = new Config("089237783227", "JKR91Vs1zEcuAj9LwMXQu-H3LPrDq1XCKItTKpmLY1-XsBgCnNpkDT1GER8ih9f-UTYoNINatMbreNIRavgu-89wPOnY6F7mz1lXP3LZ");
  }
    
  /**
   * testGetSandboxUrl
   *
   * @return void
   */
  public function testGetSandboxUrl()
  {
    $this->assertIsString($this->config->get_sandbox_url());
  }
  
  /**
   * testGetProductionUrl
   *
   * @return void
   */
  public function testGetProductionUrl()
  {
    $this->assertIsString($this->config->get_production_url());
  }
  
  /**
   * testGetMerchantId
   *
   * @return void
   */
  public function testGetMerchantId()
  {
    $this->assertIsString($this->config->get_merchant_id());
  }
  
  /**
   * testGetMerchantKey
   *
   * @return void
   */
  public function testGetMerchantKey()
  {
    $this->assertIsString($this->config->get_merchant_key());
  }
}

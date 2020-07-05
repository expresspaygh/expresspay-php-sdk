<?php

namespace Expay\SDK\Utility;

/**
 * Config
 */
class Config
{  
  /**
   * sandbox_url
   *
   * @var string
   */
  protected $sandbox_url = "";  
  /**
   * production_url
   *
   * @var string
   */
  protected $production_url = "";  
  /**
   * merchant_id
   *
   * @var string
   */
  protected $merchant_id = "";  
  /**
   * merchant_api_key
   *
   * @var string
   */
  protected $merchant_api_key = "";

  /**
   * __construct
   *
   * @param  mixed $merchant_id
   * @param  mixed $merchant_api_key
   * @return void
   */
  public function __construct(string $merchant_id, string $merchant_api_key)
  {
    $this->merchant_id = $merchant_id;
    $this->merchant_api_key = $merchant_api_key;

    $this->production_url = "https://expresspaygh.com/api/";
    $this->sandbox_url = "https://sandbox.expresspaygh.com/api/";
  }
  
  /**
   * get_sandbox_url
   *
   * @return string
   */
  public function get_sandbox_url() : string
  {
    return sprintf("%s", $this->sandbox_url);
  }

  /**
   * get_production_url
   *
   * @return string
   */
  public function get_production_url() : string
  {
    return sprintf("%s", $this->production_url);
  }
  
  /**
   * get_merchant_id
   *
   * @return string
   */
  public function get_merchant_id() : string
  {
    return sprintf("%s", $this->merchant_id);
  }
  
  /**
   * get_merchant_key
   *
   * @return string
   */
  public function get_merchant_key() : string
  {
    return sprintf("%s", $this->merchant_api_key);
  }
}
<?php

namespace Expay\SDK\Requests;

use Exception;
use Expay\SDK\Utility\Config;
use Expay\SDK\Exceptions\BadRequest;

/**
 * QueryInvoice
 */
class QueryInvoice
{  
  /**
   * request
   *
   * @var array
   */
  private $request = array();  
  /**
   * make
   *
   * @var string
   */
  private $make = array();  
  /**
   * config
   *
   * @var string
   */
  private $config = "";
  
  /**
   * __construct
   *
   * @param  mixed $request
   * @param  mixed $config
   * @return void
   */
  public function __construct(array $request, Config $config)
  {
    $this->config = $config;
    $this->request = $request;
  }
  
  /**
   * make
   *
   * @return QueryInvoice
   */
  public function make() : QueryInvoice
  {
    if (!is_object($this->config) || empty($this->config))
    {
      throw new BadRequest("Sorry, config cannot be empty");
    }

    if (!is_array($this->request) || empty($this->request))
    {
      throw new BadRequest("Sorry, request cannot be empty");
    }

    try {
      $this->make["merchant-id"] = $this->config->get_merchant_id();
      $this->make["api-key"] = $this->config->get_merchant_key();
      
      $this->make["token"] = $this->request["token"];

    } catch(Exception $e) {
      throw new BadRequest($e->getMessage());
    }

    return $this;
  }
  
  /**
   * toObject
   *
   * @return void
   */
  public function toObject() : object
  {
    return (object) $this->make;
  }
  
  /**
   * toArray
   *
   * @return void
   */
  public function toArray() : array
  {
    return $this->make;
  }
}
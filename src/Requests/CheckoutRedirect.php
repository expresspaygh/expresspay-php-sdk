<?php

namespace Expay\SDK\Requests;

use Exception;
use Expay\SDK\Utility\Config;
use Expay\SDK\Utility\Helpers;
use Expay\SDK\Exceptions\BadRequest;

/**
 * CheckoutRedirect
 */
class CheckoutRedirect
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
   * __construct
   *
   * @param  mixed $request
   * @param  mixed $config
   * @return void
   */
  public function __construct(array $request)
  {
    $this->request = $request;
  }
  
  /**
   * make
   *
   * @return CheckoutRedirect
   */
  public function make() : CheckoutRedirect
  {
    if (!is_array($this->request) || empty($this->request))
    {
      throw new BadRequest("Sorry, request cannot be empty");
    }

    try {
      $filter = new Helpers($this->request);
      $filter = $filter->clean_checkout_request();

      $this->make["token"] = $filter->output["token"];

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
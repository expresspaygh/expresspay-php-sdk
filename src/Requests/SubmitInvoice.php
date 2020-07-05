<?php

namespace Expay\SDK\Requests;

use Exception;
use Expay\SDK\Utility\Config;
use Expay\SDK\Utility\Helpers;
use Expay\SDK\Exceptions\BadRequest;

/**
 * SubmitInvoice
 */
class SubmitInvoice
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
   * @return SubmitInvoice
   */
  public function make() : SubmitInvoice
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
      $filter = new Helpers($this->request);
      $filter = $filter->clean_submit_request();

      $this->make["merchant-id"] = $this->config->get_merchant_id();
      $this->make["api-key"] = $this->config->get_merchant_key();

      $this->make["currency"] = $filter->output["currency"];
      $this->make["amount"] = $filter->output["amount"];
      $this->make['order-id'] = $filter->output["order_id"];
      $this->make['order-desc'] = $filter->output["order_desc"];
      $this->make['accountnumber'] = $filter->output["account_number"];
      $this->make['redirect-url'] = $filter->output["redirect_url"];

      if (!empty($filter->output["order_img_url"])) $this->make['order_img_url'] = $filter->output["order_img_url"];
      if (!empty($filter->output["first_name"])) $this->make['firstname'] = $filter->output["first_name"];
      if (!empty($filter->output["last_name"])) $this->make['lastname'] = $filter->output["last_name"];
      if (!empty($filter->output["phone_number"])) $this->make['phonenumber'] = $filter->output["phone_number"];
      if (!empty($filter->output["email"])) $this->make['email'] = $filter->output["email"];

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
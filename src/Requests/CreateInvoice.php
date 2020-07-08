<?php

namespace Expay\SDK\Requests;

use Exception;
use Expay\SDK\Utility\Config;
use Expay\SDK\Utility\Helpers;
use Expay\SDK\Exceptions\BadRequest;

/**
 * CreateInvoice
 */
class CreateInvoice
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
   * @return CreateInvoice
   */
  public function make() : CreateInvoice
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
      $filter = $filter->clean_create_invoice_request();

      $this->make["merchant-id"] = $this->config->get_merchant_id();
      $this->make["api-key"] = $this->config->get_merchant_key();

      $this->make["order-id"] = $filter->output["order_id"];
      $this->make["ccy"] = $filter->output["currency"];
      $this->make['trnamt'] = $filter->output["amount"];
      $this->make['payacct'] = $filter->output["account_number"];
      $this->make['description'] = $filter->output["order_desc"];
      $this->make['phone_number'] = $filter->output["phone_number"];
      $this->make['email'] = $filter->output["email"];
      $this->make['account_name'] = $filter->output["account_name"];
      $this->make['redirect-url'] = $filter->output["redirect_url"];
      $this->make['send_email'] = !empty($filter->output["email"]) ? "TRUE" : "FALSE";
      $this->make['send_sms'] = !empty($filter->output["phone_number"]) ? "TRUE" : "FALSE";

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
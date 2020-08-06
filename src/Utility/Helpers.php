<?php

namespace Expay\SDK\Utility;

use Exception;
use Expay\Refine\Filter;
use Expay\Refine\Rules\Validate;
use Expay\Refine\Rules\CleanTags;
use Expay\Refine\Rules\PHPFilter;
use Expay\Refine\Rules\CleanString;
use Expay\SDK\Exceptions\InvalidField;

/**
 * Helpers
 */
class Helpers
{  
  /**
   * data
   *
   * @var array
   */
  private $data = array();  
  /**
   * fields
   *
   * @var array
   */
  private $fields = array();
    
  /**
   * __construct
   *
   * @param  mixed $data
   * @return void
   */
  public function __construct(array $data = null)
  {
    $this->data = $data;
  }
  
  /**
   * run_filter
   *
   * @param  mixed $fields
   * @return void
   */
  private function run_filter()
  {
    try {
      return (new Filter)->addFields($this->fields)->check($this->data);
    } catch(Exception $e) {
      throw new InvalidField($e->getMessage());
    }
  }
  
  /**
   * clean_submit_request
   *
   * @return void
   */
  public function clean_submit_request()
  {
    $emailRules=["email"=>"required|email"];
    $urlRules=["redirect_url"=>"required|url"];
    $imgRules=["order_img_url"=>"required|url"];

    $this->fields = [
      "currency" => [new CleanString, new CleanTags],
      "amount" => [new PHPFilter(["float"])],
      "order_id" => [new CleanString, new CleanTags],
      "order_desc" => [new CleanString, new CleanTags],
      "redirect_url" => [new Validate($urlRules)],
      "account_number" => [new CleanString, new CleanTags],
      "order_img_url" => (!empty($this->data['order_img_url'])) ? [new Validate($imgRules)] : [new Nullable],
      "first_name" => (!empty($this->data['first_name'])) ? [new CleanString, new CleanTags] : [new Nullable],
      "last_name" => (!empty($this->data['last_name'])) ? [new CleanString, new CleanTags] : [new Nullable],
      "phone_number" => (!empty($this->data['phone_number'])) ? [new CleanString, new CleanTags] : [new Nullable],
      "email" => (!empty($this->data['email'])) ? [new Validate($emailRules), new CleanTags] : [new Nullable],
    ];

    try {
      $filterRun = (object) $this->run_filter();
      if($filterRun->status != 0) {
        throw new InvalidField($filterRun->message);
      }

      return $filterRun;
    } catch(Exception $e) {
      throw new InvalidField($e->getMessage());
    }
  }
}
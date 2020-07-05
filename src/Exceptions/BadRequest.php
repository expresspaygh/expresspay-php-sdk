<?php

namespace Expay\SDK\Exceptions;

use Exception;

/**
 * BadRequest
 */
class BadRequest extends Exception
{
  /**
   * __construct
   *
   * @param  mixed $message
   * @param  mixed $code
   * @param  mixed $previous
   * @return void
   */
  public function __construct($message, $code = null, Exception $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }
}

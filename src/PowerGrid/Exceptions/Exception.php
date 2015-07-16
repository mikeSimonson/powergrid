<?php

namespace PowerGrid\Exceptions;

class Exception extends \Exception {
  protected $defaultMessage = 'An error has occurred';

  public function __construct($message = NULL, $code = 0, $previous = NULL) {
    $instanceMessage = $message ? $message : $this->defaultMessage;

    parent::__construct($instanceMessage, $code, $previous);
  }
}

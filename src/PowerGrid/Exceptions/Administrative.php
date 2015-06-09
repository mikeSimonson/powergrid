<?php

namespace PowerGrid\Exceptions;

class Administrative extends \Exception {

  protected $defaultMessage = 'Administrative game error has occurred';

  public function __construct($message = NULL, $code = 0, $previous = NULL) {
    $instanceMessage = $message ? $message : $this->defaultMessage;

    parent::__construct($instanceMessage, $code, $previous);
  }
}

<?php

class Administrative extends \Exception {

  protected $defaultMessage = 'Administrative game error has occurred';

  public function __construct($message = NULL, $code, $previous = NULL) {
    $instanceMessage = $message ? $message : $this->defaultMessage;

    parent::__construct($instanceMessage, $code, $previous);
  }
}

<?php

namespace PowerGrid\Exceptions\Application;

class UnexpectedParameterType extends \PowerGrid\Exceptions\Application {
  protected $defaultMessage = 'Unexpected paramter type';

  public function __construct($instanceMessage = NULL) {
    if ($instanceMessage == NULL) {
      $instanceMessage = $this->defaultMessage;
    }

    parent::__construct($instanceMessage);
  }
}

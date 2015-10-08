<?php

namespace PowerGrid\Exceptions\Application;

class BadGameConfigFormat extends \PowerGrid\Exceptions\Application {
  protected $defaultMessage = 'Game configuration parsing failed due to an invalid Game config file.';

  public function __construct($parseError = NULL) {
    if ($parseError) {
      $instanceMsg = $parseError;
    }
    else {
      $instanceMsg = $this->defaultMessage;
    }

    parent::__construct($instanceMsg);
  }
}

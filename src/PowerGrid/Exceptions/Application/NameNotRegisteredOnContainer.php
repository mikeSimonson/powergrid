<?php

namespace PowerGrid\Exceptions\Application;

class NameNotRegisteredOnContainer extends PowerGrid\Exceptions\Application {
  protected $defaultMessage = 'Class not registered on container';

  public function __construct($referenceName, $containerName) {
    if (is_string($referenceName) && is_string($containerName)) {
      $instanceMessage = "Name $referenceName not registered on the container of class $containerName";
    }
    else {
      $instanceMessage = $this->defaultMessage;
    }

    parent::__construct($instanceMessage);
  }
}

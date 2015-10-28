<?php

namespace PowerGrid\Exceptions\Application;

class RegisteredClassDoesNotExistInContainer extends PowerGrid\Exceptions\Application {
  protected $defaultMessage = 'Class not registered on container';

  public function __construct($className, $containerName) {
    if (is_string($className) && is_string($containerName)) {
      $instanceMessage = "Class $className does not exist in the container of class $containerName. Make sure its namespace has been added to the container.";
    }
    else {
      $instanceMessage = $this->defaultMessage;
    }

    parent::__construct($instanceMessage);
  }
}

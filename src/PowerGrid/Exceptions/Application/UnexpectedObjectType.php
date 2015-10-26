<?php

namespace PowerGrid\Exceptions\Application;

class UnexpectedObjectType extends \PowerGrid\Exceptions\Exception {
  protected $defaultMessage = 'Unexpected object type.';

  public function __construct($expectedType, $receivedObject) {
    $receivedClass = get_class($receivedObject);
    $receivedInterfaces = implode(', ', class_implements($receivedClass));
    $message = "Expected type $expectedType, received $receivedClass, which implements $receivedInterfaces.";
    parent::__construct($message);
  }
}

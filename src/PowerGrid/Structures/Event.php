<?php

namespace PowerGrid\Structures;

class Event {
  protected $name;
  protected $namespace;
  protected $object;

  public function __construct($name, $namespace = '', $object = NULL, $status = NULL) {
    $this->name = $name;
    $this->namespace = $namespace;
    $this->object = $object;
    $this->status = $status;
  }

  public function getName() {
    return $this->name;
  }

  public function getNamespace() {
    return $this->namespace;
  }

  public function getObject() {
    return $this->object;
  }

  public function getStatus() {
    return $this->status;
  }

  static public function create() {
    return new static();
  }
}

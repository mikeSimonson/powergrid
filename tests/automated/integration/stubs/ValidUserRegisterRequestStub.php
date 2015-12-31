<?php

namespace Tests\Stubs;

class ValidUserRegisterRequestStub {
  static protected $usernameIndex = 0;
  static protected $emailIndex = 0;

  public function __call($method, $arguments) {
    $availableMethods = array(
      'post',
      'get',
      'params'
    );

    if (in_array($method, $availableMethods)) {
      return $this->call($arguments[0]);
    }

    throw new Exception("No method $method in stub");
  }

  public function call($param) {
    return $this->$param;
  }

  public function __set($param, $value) {
    $this->$param = $value;
    return $this->$param;
  }

}

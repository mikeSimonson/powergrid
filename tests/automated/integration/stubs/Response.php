<?php

namespace Tests\Stubs;

class Response {
  public $status;

  public function setStatus($statusCode) {
    $this->status = $statusCode;
  }

  public function __call($method, $arguments) {}
}

<?php

namespace HTTPPowerGrid\Exceptions\Application;

class UserDoesNotExist extends \HTTPPowerGrid\Exceptions\Exception {
  protected $defaultMessage = 'User does not exist';

  public function __construct($userId = NULL) {
    $instanceMessage = is_numeric($userId) ? "User ID $userId does not exist" : $this->defaultMessage;

    parent::__construct($instanceMessage);
  }
}

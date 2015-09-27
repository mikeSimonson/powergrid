<?php

namespace PowerGrid\Exceptions\Application;

class BadGameConfigFormat extends \PowerGrid\Exceptions\Application {
  protected $defaultMessage = 'Game configuration parsing failed due to an invalid Game config file.';
}

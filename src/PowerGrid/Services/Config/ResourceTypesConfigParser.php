<?php

namespace PowerGrid\Services\Config;

class ResourceTypesConfigParser extends \PowerGrid\Abstracts\ConfigParser {
  protected function mangle() {
    return $this->preMangle;
  }

  protected function checkValidity() {
    foreach ($this->preMangle AS $resourceName) {
      if (!is_string($resourceName)) {
        throw new \PowerGrid\Exceptions\Application\BadGameConfigFormat("All resource names must be a string. $resourceName is not a string.");
      }
    }
  }
}

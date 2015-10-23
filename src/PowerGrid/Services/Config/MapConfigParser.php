<?php

namespace PowerGrid\Services\Config;

class MapConfigParser extends \PowerGrid\Abstracts\ConfigParser {
  protected function checkValidity() {
    foreach ($this->preMangle() AS $city_name) {
      if (!is_string($city_name)) {
        throw new \PowerGrid\Exceptions\Application\BadGameConfigFormat();
      }
    }
  }

  protected function mangle() {
    return $this->preMangle();
  }
}

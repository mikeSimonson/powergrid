<?php

namespace PowerGrid\Services\Config;

class MapConfigParser extends \PowerGrid\Abstracts\ConfigParser {
  protected function checkValidity() {
    if (!is_string($this->preMangle['name'])) {
      throw new \PowerGrid\Exceptions\Application\BadGameConfigFormat();
    }

    if (!array_filter($this->preMangle['filenames'], 'is_string')) {
      throw new \PowerGrid\Exceptions\Application\BadGameConfigFormat();
    }
  }

  protected function mangle() {
    return $this->preMangle;
  }
}

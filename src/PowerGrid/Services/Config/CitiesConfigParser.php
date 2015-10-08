<?php

namespace PowerGrid\Services\Config;

class CitiesConfigParser extends \PowerGrid\Abstracts\ConfigParser {
  protected function mangle() {
    return $this->preMangle;
  }

  protected function checkValidity() {
    $parseError = FALSE;

    $currentIndex = 0;
    while ($parseError == FALSE && $currentIndex < count($this->preMangle)) {
      $cityName = $this->preMangle[$currentIndex];

      if (!is_string($cityName)) {
        $parseError = TRUE;
      }

      ++$currentIndex;
    }

    if ($parseError) {
      throw new \PowerGrid\Exceptions\Application\BadGameConfigFormat();
    }
  }
}

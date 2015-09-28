<?php

namespace PowerGrid\Services\Config;

class CityConnectionsConfigParser extends \PowerGrid\Abstracts\ConfigParser {
  protected function mangle() {
    return $this->preMangle;
  }

  protected function checkValidity() {
    $parseError = FALSE;

    $currentIndex = 0;
    while ($parseError == FALSE && $currentIndex < count($this->current)) {
      $cardSetObj =  $this->preMangle[$currentIndex];

      // Make sure both name and filename attributes exist
      if (!isset($cardSetObj['name'], $cardSetObj['filename']) {
        $parseError = TRUE;
      }
      else if (!is_string($cardSetObj['name']) || !is_string($cardSetObj['filename'])) {
        $parseError = TRUE;
      }

      ++$currentIndex
    }

    if ($parseError) {
      throw new \PowerGrid\Exceptions\Application\BadGameConfigFormat();
    }
  }
}

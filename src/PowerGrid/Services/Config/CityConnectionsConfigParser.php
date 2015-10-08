<?php

namespace PowerGrid\Services\Config;

class CityConnectionsConfigParser extends \PowerGrid\Abstracts\ConfigParser {
  protected function mangle() {
    return $this->preMangle;
  }

  protected function checkValidity() {
    $parseError = FALSE;

    $currentIndex = 0;
    while ($parseError == FALSE && $currentIndex < count($this->preMangle)) {
      $connectionObj = $this->preMangle[$currentIndex];
      // Make sure both cities and price attributes exist
      if (!isset($connectionObj['cities'], $connectionObj['price'])) {
        $parseError = 'Must have both cities and price attributes on connection item';
      }
      // Check the cities attribute
      else if (count($connectionObj['cities']) !== 2 ||
        !(is_numeric($connectionObj['cities'][0]) && is_numeric($connectionObj['cities'][1]))) {
        $parseError = 'Cities attribute must have two numeric items';
      }
      // Check the price attribute
      else if (!is_numeric($connectionObj['price'])) {
        $parseError = 'Price attribute must be numeric';
      }

      ++$currentIndex;
    }

    if ($parseError) {
      throw new \PowerGrid\Exceptions\Application\BadGameConfigFormat($parseError);
    }
  }
}

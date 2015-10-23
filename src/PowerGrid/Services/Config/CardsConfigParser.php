<?php

namespace PowerGrid\Services\Config;

class CardsConfigParser extends \PowerGrid\Abstracts\ConfigParser {
  protected function mangle() {
    return $this->preMangle;
  }

  protected function checkValidity() {
    // Card config must be an array
    if (!is_array($this->preMangle)) {
      throw new \PowerGrid\Exceptions\Application\BadGameConfigFormat();
    }

    foreach ($this->preMangle AS $cardConfig) {
      
      // These fields must be numeric in the config
      $numeric_fields = array(
        'starting_auction_price',
        'resource_cost',
        'power_output'
      );
      foreach ($numeric_fields AS $numeric_field) {
        if (!is_numeric($cardConfig[$numeric_field])) {
          throw new \PowerGrid\Exceptions\Application\BadGameConfigFormat();
        }
      }

      // Resource types must be an array of numeric values
      if (!array_filter($cardConfig['resource_types'], 'is_int')) {
        throw new \PowerGrid\Exceptions\Application\BadGameConfigFormat();
      }
    }
  }
}

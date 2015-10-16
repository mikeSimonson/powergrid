<?php

namespace HTTPPowerGrid\Services;

class CardServices {
  static public function findCardById($cardId) {
    $card = \CardQuery::create()->findPK($cardId);
    if (is_null($card)) {
      throw new \PowerGrid\Exceptions\Administrative\CardDoesNotExist($cardId);
    }
  }
}

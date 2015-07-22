<?php

namespace HTTPPowerGrid\Services;

class GameServices extends \PowerGrid\Services\GameServices {
  static public function findGameById($gameId) {
    $game = \GameQuery::create()->findPK($gameId);

    return $game;
  }
}

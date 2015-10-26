<?php

namespace HTTPPowerGrid\Services;

use Propel\Runtime\ActiveQuery\Criteria;

class GameDeckSearcher extends \PowerGrid\Abstracts\GameDeckSearcher {
  public function getCheapestCards($quantity) {
    $firstCards = \GameDeckCardQuery::create()
      ->useGameCardQuery()
        ->useCardQuery()
          ->orderBy('starting_auction_price', Criteria::ASC)
        ->endUse()
      ->endUse()
      ->filterByGame($this->game)
      ->limit($quantity)
      ->find();

    return $firstCards;
  }
}

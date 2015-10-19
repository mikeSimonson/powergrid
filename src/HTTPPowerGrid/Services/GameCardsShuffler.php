<?php

namespace HTTPPowerGrid\Services;

class GameCardsShuffler extends \PowerGrid\Services\GameCardsShuffler {
  protected function removeRandomCard() {
    $card = parent::removeRandomCard();
    $card->delete();
    return $card;
  }
}

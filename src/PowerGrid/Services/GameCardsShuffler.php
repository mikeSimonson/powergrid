<?php

namespace PowerGrid\Services;

class GameCardsShuffler {

  protected $deckCards;
  protected $game;

  public function __construct(\PowerGrid\Interfaces\GameData $game) {
    $this->game = $game;
  }

  public function setDeckCards($deckCards) {
    foreach ($deckCards AS $deckCard) {
      if (!($deckCard instanceof \PowerGrid\Interfaces\GameDeckCardData)) {
        throw new \PowerGrid\Exceptions\Application\UnexpectedObjectType('Array of \PowerGrid\Interfaces\GameDeckCardData', $deckCard);
      }
    }

    $this->deckCards = $deckCards;
  }

  public function shuffle() {
    $deck_positions = range(1, count($this->deckCards));
    shuffle($deck_positions);
    foreach ($this->deckCards AS $deckCard) {
      $deckCard->setDeckPosition(array_pop($deck_positions));
    }
  }
}

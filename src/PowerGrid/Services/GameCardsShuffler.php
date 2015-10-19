<?php

namespace PowerGrid\Services;

class GameCardsShuffler implements \PowerGrid\Interfaces\Service {

  protected $gameData;

  public function __construct(\PowerGrid\Interfaces\GameData $gameData, Array $gameCards) {
    foreach ($gameCards AS $gameCard) {
      if (!($gameCard instanceof \PowerGrid\Interfaces\GameCardData)) {
        throw new \PowerGrid\Exceptions\Application\UnexpectedObjectType('Array of \PowerGrid\Interfaces\GameCardData', $gameCard);
      }
    }
    $this->gameData = $gameData;
    $this->gameCards = $gameCards;
  }

  public function shuffle() {
    $randomized_deck_positions = shuffle(range(1, count($this->gameCards)));
    foreach ($this->gameCards AS $card) {
      $card->setDeckPosition(array_pop($randomized_deck_positions));
    }
  }

  public function removeExtraCards() {
    switch ($this->gameData->countPlayers()) {
      case 2:
      case 3:
        $numberToRemove = 8;
      case 4:
        $numberToRemove = 4;
      default:
        $numberToRemove = 0;
    }

    for ($i = 0; $i < $numberToRemove; ++$i) {
      $this->removeRandomCard();
    }
  }

  /**
   * Returns removed card.
   */
  protected function removeRandomCard() {
    $card = array_pop($this->gameCards);
    return $card;
  }
}

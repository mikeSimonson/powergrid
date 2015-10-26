<?php

namespace PowerGrid\Abstracts;

abstract class GameDeckStarter {

  protected $game;
  protected $cardShuffler;

  public function __construct(\PowerGrid\Interfaces\GameData $game, \PowerGrid\Interfaces\CardSetData $cardSet, \PowerGrid\Services\GameCardsShuffler $cardShuffler) {
    $this->game = $game;
    $this->cardSet = $cardSet;
    $this->cardShuffler = $cardShuffler;
  }

  public function setup() {
    $this->addCardsToGame();
    $this->addGameCardsToDeck();
    $this->cardShuffler->setDeckCards($this->getDeckCards());
    $this->cardShuffler->shuffle();
    $this->removeExtraCards();
  }

  protected function addCardsToGame() {
    $cards = $this->cardSet->getCards();
    foreach ($cards AS $card) {
      $this->createGameCardUsingCard($card);
    }
  }

  public function removeExtraCards() {
    switch ($this->game->countPlayers()) {
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

  abstract protected function createGameCardUsingCard(\PowerGrid\Interfaces\CardData $card);

  abstract protected function addGameCardsToDeck();

  abstract protected function getDeckCards();
}

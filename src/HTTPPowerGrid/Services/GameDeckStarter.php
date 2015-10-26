<?php

namespace HTTPPowerGrid\Services;

class GameDeckStarter extends \PowerGrid\Abstracts\GameDeckStarter {

  protected $createdDeckCards;
  protected $createdGameCards;

  protected function createGameCardUsingCard(\PowerGrid\Interfaces\CardData $card) {
    $gameCard = new \GameCard();
    $gameCard->setGame($this->game);
    $gameCard->setCard($card);
    $gameCard->save();

    $this->createdGameCards[] = $gameCard;
  }

  protected function addGameCardsToDeck() {
    $deckPosition = 1;
    foreach ($this->createdGameCards AS $gameCard) {

      $deckCard = new \GameDeckCard();
      $deckCard->setGame($this->game);
      $deckCard->setGameCard($gameCard);
      $deckCard->setDeckPosition($deckPosition);
      $deckCard->save();

      $this->createdDeckCards[] = $deckCard;

      ++$deckPosition;
    }
  }

  protected function removeRandomCard() {
    $locallyRemovedCard = parent::removeRandomCard();
    $locallyRemovedCard->delete();
    return $locallyRemovedCard;
  }

  protected function getDeckCards() {
    return $this->createdDeckCards;
  }
}

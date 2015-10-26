<?php

namespace PowerGrid\Abstracts;

abstract class AuctionStarter {
  protected $game;
  protected $gameDeck;

  public function __construct(\PowerGrid\Interfaces\GameData $game, \PowerGrid\Abstracts\GameDeckSearcher $gameDeck) {
    $this->game = $game;
    $this->gameDeck = $gameDeck;
  }

  public function setup() {
    $this->moveDeckCardsIntoAuction($this->gameDeck->getCheapestCards(8));
  }

  abstract protected function moveDeckCardsIntoAuction($deckCards);
}

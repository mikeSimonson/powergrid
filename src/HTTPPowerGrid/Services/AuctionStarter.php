<?php

namespace HTTPPowerGrid\Services;

class AuctionStarter extends \PowerGrid\Abstracts\AuctionStarter {
  protected function moveDeckCardsIntoAuction($deckCards) {
    foreach ($deckCards AS $deckCard) {
      $auctionCard = new \GameAuctionCard();
      $auctionCard->setGame($this->game);
      $auctionCard->setGameCard($deckCard->getGameCard());
      $auctionCard->save();
    }
  }
}

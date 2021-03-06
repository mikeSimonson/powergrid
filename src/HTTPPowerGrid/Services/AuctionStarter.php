<?php

namespace HTTPPowerGrid\Services;

class AuctionStarter extends \PowerGrid\Abstracts\AuctionStarter {
  protected function moveDeckCardsIntoAuction($deckCards) {
    foreach ($deckCards AS $deckCard) {
      $auctionCard = new \GameAuctionCard();
      $auctionCard->setGame($this->game);
      $auctionCard->setGameCard($deckCard->getGameCard());
      $auctionCard->save();
      $deckCard->delete();
    }
  }

  protected function createCurrentAuctionPlant($eventObject) {
    $currentAuctionPlant = \CurrentAuctionPlantQuery::create()
      ->findByPK($this->game->getId());

    if (!$currentAuctionPlant) {
      $currentAuctionPlant = new \CurrentAuctionPlant();
    }

    $currentAuctionPlant->setCard($eventObject['powerPlant']);
    $currentAuctionPlant->setHighestBid($eventObject['bid']);
    $currentAuctionPlant->setHighestBidder($eventObject['player']);
    $currentAuctionPlant->setRoundNumber($this->game->getRoundNumber());

    $currentAuctionPlant->save();
  }

  protected function createAuctionActionForPlayer($player, $currentAuctionPlant, $eventObject) {
    $playerAuctionAction = new \PlayerAuctionAction();
    $playerAuctionAction->setGame($this->game);
    $playerAuctionAction->setRoundNumber($this->game->getRoundNumber());
    $playerAuctionAction->setPlayer($player);

    if ($player->getId() == $eventObject['player']->getId()) {
      $playerAuctionAction->setActed(TRUE);
      $playerAuctionAction->setBidAmount($eventObject['bid']);
    }
    else {
      $playerAuctionAction->setActed(FALSE);
    }

    $playerAuctionAction->save();
  }

  protected function updateAuctionActionForPlayer($player, $eventObject) {
    $playerAuctionAction = \PlayerAuctionActionQuery::create()
      ->filterByGame($this->game)
      ->filterByPlayer($player)
      ->orderBy('round_number', Criteria::DESC)
      ->limt(1);
    $playerAuctionAction->setActed(TRUE);
    $playerAuctionAction->setBidAmount($eventObject['bid']);
    $currentAuctionPlant = $playerAuctionAction->getCurrentAuctionPlant();

    if ($eventObject['bid'] > $currentAuctionPlant->getHighestBid()) {
      $currentAuctionPlant->setHighestBid($eventObject['bid']);
      $currentAuctionPlant->setHighestBidder($player);
    }
    
    $currentAuctionPlant->save();
    $playerAuctionAction->save();
  }

  protected function giveWinningPlayerCard($eventObject) {
    $currentAuctionPlant = \CurrentAuctionPlantQuery::create()
      ->findOneByPK($this->game->getId());

    $auctionCard = $currentAuctionPlant->getCard();
    $gameCard = $auctionCard->getGameCard();

    $auctionCard->delete();
    
    $player = $currentAuctionPlant->getHighestBidder();

    $playerCard = new \PlayerCard();
    $playerCard->setPlayer($player);
    $playerCard->setCard($gameCard);
  }
}

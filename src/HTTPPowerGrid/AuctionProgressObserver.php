<?php

namespace HTTPPowerGrid;

use Propel\Runtime\ActiveQuery\Criteria;

class AuctionProgressObserver extends \PowerGrid\Abstracts\AuctionProgressObserver {
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
    $playerAuctionAction->setCurrentAuctionPlant($currentAuctionPlant);

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

  protected function auctionIsComplete($eventObject) {
    $auctionComplete = FALSE;
    // Auction is complete when all but the highest bidder have passed.
    $playersWhoHavePassed = \PlayerAuctionActionQuery::create()
      ->filterByGame($this->game)
      ->filterByHasPassed(FALSE)
      ->orderBy('round_number', Criteria::Desc)
      ->limit($this->game->countPlayers())
      ->find();

    if (count($playersWhoHavePassed) == $this->game->countPlayers() - 1) {
      $auctionComplete = TRUE;
    }

    return $auctionComplete;
  }

  protected function giveWinningPlayerCard($eventObject) {
    $currentAuctionPlant = \CurrentAuctionPlantQuery::create()
      ->findOneByPK($this->game->getId());

    $card = $currentAuctionPlant->getCard();
    $gameCard = \GameCardQuery::create()
      ->filterByGame($this->game)
      ->filterByCard($card)
      ->findOne();
    $auctionCard = \GameAuctionCardQuery::create()
      ->findOneByGameCard($gameCard);
    $auctionCard->delete();

    $player = $currentAuctionPlant->getHighestBidder();
  }
}

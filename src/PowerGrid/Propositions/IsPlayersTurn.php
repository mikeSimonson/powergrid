<?php

namespace PowerGrid\Propositions;

use \Ruler\RuleBuilder;

class IsPlayersTurn implements \Ruler\Proposition {
  public function evaluate(\Ruler\Context $context) {
    $player = $context['player'];
    $game = $player->getGame();
    $turnNumber = $game->getTurnNumber();
    $roundNumber = $game->getRoundNumber();
    $playerQuantity = $game->countPlayers();
    $turnOrderRank = $turnNumber % ($roundNumber * $playerQuantity);

    $matchingTurn = array_filter($player->getTurnOrders(), function($turnOrder) use ($turnOrderRank) {
      return $turnOrder->getRank() == $turnOrderRank;
    });

    return bool($matchingTurn);
  }
}

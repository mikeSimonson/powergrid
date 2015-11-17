<?php

namespace PowerGrid\Propositions;

use \Ruler\RuleBuilder;

class PlayerHasEnoughMoneyForBid implements \Ruler\Proposition {
  public function evaluate(\Ruler\Context $context) {
    $playerWallet = $context['player']->getPlayerWallet();
    $bid = $context['bid'];

    $result = $playerWallet->getBalance() >= intval($bid);

    return $result;
  }
}

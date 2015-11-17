<?php

namespace PowerGrid\Rulesets\Step1;

class StartBidAction extends \PowerGrid\Abstracts\ActionRuleset {

  /**
   * Add any rules to the ruleSet.
   *
   * This will call the Rule-building methods that return Rules, and then add 
   * their return values to the ruleSet.
   *
   * @param   void
   * @return  void
   */
  protected function compileRules() {
    $this->ruleSet->addRule($this->startBid());
  }

  protected function startBid() {
    $operator = $this->plantChoosable();
    $action = $this->choosePlantAction();

    return $this->combineOperatorWithAction($operator, $action);
  }

  protected function plantChoosableConditions() {
    $operator = $this->rb->logicalAnd(
      $this->propositions->IsPlayersTurn(),
      $this->propositions->PlayerHasEnoughMoneyForBid(),
      $this->propositions->BidIsAtLeastStartingCostOfPlant()
    );

    // it must be time to bid on a new plant
    // it must be the player's turn
    // user must have enough money
    // bid must be at least the starting cost of the plant
    return $operator;
  }

  protected function choosePlantAction() {
    $action = function() {
      $playerAuctionAction = $this->context['player']->getPlayerAuctionAction();
      $playerAuctionAction->setActed(TRUE);
    };

    return $action;
  }
}

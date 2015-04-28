<?php

namespace PowerGrid\Rulesets\Step1;

class NewTurnOrder extends \PowerGrid\Abstracts\ActionRuleset {

  /**
   * Adds all rules to the ruleSet
   *
   * @param   void
   * @return  void
   */
  protected function compileRules() {
    $this->ruleSet->addRule($this->initializeTurnOrder());
  }

  protected function initializeTurnOrder() {
    $operator = $this->isNewGame();
    $action = $this->randomlyShufflePlayers();

    return $this->combineOperatorWithAction($operator, $action);
  }

  protected function isNewGame() {
    $conditions = $this->rb->logicalOr(
      $this->rb['currentTurnOrder']->equalTo(NULL)
    );
    return $conditions;
  }

  protected function randomlyShufflePlayers() {
    $action = function() {
      $players = $this->gameData->getPlayers();
      var_dump($players);
      $playerOrder = array();
      foreach ($players as $player) {
        $playerOrder[] = $player->getId();
      }
      var_dump($playerOrder);
      shuffle($playerOrder);

      var_dump($playerOrder);
      $this->gameData->setPlayerTurnOrder($playerOrder);
    };

    return $action;
  }
}

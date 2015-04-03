<?php

namespace \PowerGrid\Abstracts;

abstract class Game implements \PowerGrid\Interfaces\GameControls {

  /**
   * @param   obj     A proxy for the game data. 
   * @param   array   An assoc array with 
   */
  public function __construct(\PowerGrid\Interfaces\GameData $dataSource, \PowerGrid\RuleFactory $ruleFactory) {
    $this->gameData = $dataSource;
    $this->ruleFactory = $ruleFactory;

    // Shuffle and create card stack
  }

  /**
   * Should give all info a player needs to make a strategic
   * play decision.
   * 
   * @param   void
   *
   * @return  array
   */
  public function getInfo() {
  }

  public function determineTurnOrder() {
    $action = \PowerGrid\Interfaces\GameData::NEW_TURN_ORDER_ACTION;
    $context = array();
    $this->performAction($action, $context);
    $this->notifyNextPlayer();
  }

  /**
   * @param   int
   */
  public function startBid($playerId, $powerPlantId) {
    $action = \PowerGrid\Interfaces\GameData::START_BID_ACTION;
    $context = array(
      'playerId' => $playerId,
      'powerPlantId' => $powerPlantId
    );
    $this->performAction($action, $context);
    $this->notifyNextPlayer();
  }

  /**
   * @param   int
   * @param   int
   */ 
  public function placeBid($playerId, $powerPlantId, $bidAmount) {
    $action = \PowerGrid\Interfaces\GameData::PLACE_BID_ACTION;
    $context = array(
      'playerId' => $playerId,
      'powerPlantId' => $powerPlantId,
      'bidAmount' => $bidAmount
    );
    $this->performAction($action, $context);
    $this->notifyNextPlayer();
  }

  /**
   * @param array   $resource_name => $resource_quantity
   */
  public function buyResources($resourceOrder) {
    $action = \PowerGrid\Interfaces\GameData::BUY_RESOURCES_ACTION;
    $context = array(
      'resourceOrder' => $resourceOrder
    );
    $this->performAction($action, $context);
    $this->notifyNextPlayer();
  }

  /**
   * @param array
   */
  public function buildCities($cityNames) {
    $action = \PowerGrid\Interfaces\GameData::BUILD_CITIES_ACTION;
    $context = array(
      'cityNames' => $cityNames
    );
    $this->performAction($action, $context);
    $this->notifyNextPlayer();
  }

  /**
   * @param   int
   * @param   array   $resource_name => $resource_quantity
   */
  public function powerCities($quantity, $resourcePayment) {
    $action = \PowerGrid\Interfaces\GameData::POWER_CITIES_ACTION;
    $context = array(
      'quantity' => $quantity,
      'resourcePayment' => $resourcePayment
    );
    $this->performAction($action, $context);
    $this->notifyNextPlayer();
  }

  protected function performAction($action, $contextMap) {
    $this->startAction();

    $rules = $this->getRules($action);
    $turnData = new \Ruler\Context($contextMap);
    $rulesResult = $rules->execute($this->gameData, $turnData);

    $this->finishAction($rulesResult);
  }

  protected function getRules($action) {
    $stepId = $this->gameData->getCurrentStep();
    $rules = $this->ruleFactory->makeRules($stepId, $action);
  }

  protected function notifyNextPlayer($action) {
    // We need to figure out how to determine what the next player's action
    // will be.
  }

  /**
   * Run at the start of any action.
   *
   * @param   void
   * @return  void
   */
  abstract protected function startAction();

  /**
   * Run at the end of any action, but before the next player is notified
   * of his/her next action (since notifying a player is not part of an
   * action).
   *
   * @param   bool  Whether the rules were passed and actions taken.
   */
  abstract protected function finishAction($rulesRunResult);
}

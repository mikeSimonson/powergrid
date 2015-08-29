<?php

namespace PowerGrid\Abstracts;

abstract class Game implements \PowerGrid\Interfaces\GameControls {

  protected $players = array();
  protected $ruleFactory = NULL;

  /**
   * @param   obj     A proxy for the game data. 
   * @param   obj     A rule factory.
   * @param   obj     An assoc array of \PowerGrid\Abstract\Player objs.
   */
  public function __construct(\PowerGrid\Interfaces\GameData $dataSource, \PowerGrid\Factories\RuleFactory $ruleFactory) {

    //@TODO: Need some way to get Player objects and validate those players

    $this->gameData = $dataSource;
    $this->ruleFactory = $ruleFactory;
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
    $context = array('currentTurnOrder' => $this->gameData->getPlayerTurnOrder());
    $this->performAction($action, $context);
    //$this->notifyNextPlayer();
  }

  /**
   * @param   int
   */
  public function startBid(\PowerGrid\Interfaces\PlayerData $player, \PowerGrid\Interfaces\PowerPlantData $powerPlant) {
    $action = \PowerGrid\Interfaces\GameData::START_BID_ACTION;
    $context = array(
      'player' => $player,
      'powerPlant' => $powerPlant
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
  public function buyResources($playerId, $resourceOrder) {
    $action = \PowerGrid\Interfaces\GameData::BUY_RESOURCES_ACTION;
    $context = array(
      'playerId' => $playerId,
      'resourceOrder' => $resourceOrder
    );
    $this->performAction($action, $context);
    $this->notifyNextPlayer();
  }

  /**
   * @param array
   */
  public function buildCities($playerId, $cityNames) {
    $action = \PowerGrid\Interfaces\GameData::BUILD_CITIES_ACTION;
    $context = array(
      'playerId' => $playerId,
      'cityNames' => $cityNames
    );
    $this->performAction($action, $context);
    $this->notifyNextPlayer();
  }

  /**
   * @param   int
   * @param   array   $resource_name => $resource_quantity
   */
  public function powerCities($playerId, $quantity, $resourcePayment) {
    $action = \PowerGrid\Interfaces\GameData::POWER_CITIES_ACTION;
    $context = array(
      'playerId' => $playerId,
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
    $rules->execute($this->gameData, $turnData);

    $this->finishAction();
  }

  protected function getRules($action) {
    $stepId = $this->gameData->getStepNumber();
    $rules = $this->ruleFactory->makeRules($stepId, $action);

    return $rules;
  }

  protected function notifyNextPlayer() {
    $nextPlayerId = $this->gameData->getNextPlayerId();
    $nextAction = $this->gameData->getNextPhaseId();

    $this->players[$nextPlayerId]->notify($nextAction);
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
   */
  abstract protected function finishAction();
}

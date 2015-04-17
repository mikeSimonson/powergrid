<?php

namespace HTTPPowerGrid;

class GameData extends \Game implements \PowerGrid\Abstracts\GameData {

  public function __construct() {
    parent::__construct();

    $this->setTurnNumber(0);
    $this->setStepNumber(0);
  }

  /* GETTERS */

  public function getCurrentPhaseId() {
  
  }

  public function getCurrentStepId() {
  
  }

  public function getNextPhaseId() {
  
  }

  public function getNextPlayerId() {
  
  }

  /* SETTERS */

  public function setPlayerIds($playerIds) {
    
  }

}

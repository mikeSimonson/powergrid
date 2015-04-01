<?php

namespace \PowerGrid\Interfaces;

abstract class ActionRuleset {

  protected $ruleSet;

  public function __construct() {
    $this->ruleSet = new \Ruler\RuleSet();

    $this->ruleSet->addRule();
  }

  abstract public function execute(\PowerGrid\Interfaces\GameData $gameData, \Ruler\Context $turnData);

}

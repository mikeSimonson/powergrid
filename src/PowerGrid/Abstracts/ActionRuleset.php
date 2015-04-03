<?php

namespace \PowerGrid\Abstracts;

abstract class ActionRuleset {
  protected $ruleSet;

  public function __construct() {
    $this->ruleSet = new \Ruler\RuleSet();

    $this->compileRules();
  }

  public function execute(\PowerGrid\Interfaces\GameData &$gameData, \Ruler\Context $turnData) {
    return $this->ruleSet->executeRules();
  }

  /**
   * Add any rules to the ruleSet
   *
   * @param   void
   * @return  void
   */
  abstract protected function compileRules();
}

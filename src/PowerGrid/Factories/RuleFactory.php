<?php

namespace PowerGrid\Factories;

class RuleFactory {

  /**
   * 
   *
   * @param int   Step ID
   * @param str   Action name
   */
  public function makeRules($stepId, $action) {
    $actionFactory = $this->makeActionFactory($stepId);

    $actionRuleset = $actionFactory->makeActionRuleset($action);

    return $actionRuleset;
  }

  public function makeActionFactory($stepId) {
    $actionFactory;

    switch ($stepId) {
      case 1:
        $actionFactory = new \PowerGrid\Factories\Step1Factory();
        break;
      case 2:
        $actionFactory = new \PowerGrid\Factories\Step2Factory();
        break;
      case 3:
        $actionFactory = new \PowerGrid\Factories\Step3Factory();
        break;
      default:
        throw new \Exception("No step $stepId action factory available.");
        break;
    }

    return $actionFactory;
  }
}

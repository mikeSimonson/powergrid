<?php

namespace PowerGrid\Abstracts;

abstract class ActionRuleset {
  protected $ruleSet;
  protected $game;

  public function __construct() {
    $this->ruleSet = new \Ruler\RuleSet();
    $this->ruleBuilder = new \Ruler\RuleBuilder();
    $this->rb = $this->ruleBuilder;

    $this->compileRules();
  }

  public function execute(\PowerGrid\Interfaces\GameData $game, \Ruler\Context $context) {
    $this->game = $game;
    $this->context = $context;

    $this->ruleSet->executeRules($this->context);

    return $this->game;
  }

  /**
   * Add any rules to the ruleSet.
   *
   * This will call the Rule-building methods that return Rules, and then add 
   * their return values to the ruleSet.
   *
   * @param   void
   * @return  void
   */
  abstract protected function compileRules();

  /**
   * This should be used to combine any operator and action. Binds the action to 
   * $this.
   *
   * Rule-making methods that are called in compileRules should use this method 
   * to build their return value, unless they do not care to use the context of 
   * this object in their action.
   *
   * @param   \Ruler\Operator   The operator to combine with the action.
   * @param   \Closer           The action, which will be bound to $this in this 
   *                            method.
   *
   * @return  \Ruler\Rule
   */
  protected function combineOperatorWithAction(\Ruler\Operator $operator, \Closure $action) {
    $action->bindTo($this);
    $combinedRuleAction = $this->ruleBuilder->create($operator, $action);
    return $combinedRuleAction;
  }

  /**
   * Additionally, add any Rule-builders that you want here. These will return 
   * Rules that you will add to the ruleSet in compileRules.
   */

  /*
    
    Rule-builder example:

    protected function getPlayerExistsRule() {
      $userLoggedIn = $this->ruleBuilder['players']->setContains($this->ruleBuilder['playerId']);
        
      $logUserLoggedIn = function() {
        $this->logger->log('INFO', 'Player ' . $this->ruleBuilder['playerId'] . ' exists.');
      };

      $rule = $this->combineOperatorWithAction($userLoggedIn, $logUserLoggedIn);

      return $rule;
    }
 
  */
}

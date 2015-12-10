<?php

class RulerTest extends PHPUnit_Framework_TestCase {

  public function testRulesWithActionsCanBeEvaluatedAndExecuted() {

    $message = '';

    $rb = new \Ruler\RuleBuilder();

    $rule = $rb->create(
      $rb->logicalAnd(
        $rb['isZero']->equalTo($rb['zero']),
        $rb['isOne']->equalTo($rb['one'])
      ),
      function() use (&$message) {
        $message = 'Correct';
      }
    );

    $context = new \Ruler\Context(array(
      'isZero' => 0,
      'zero' => 0,
      'isOne' => 1,
      'one' => 1
    ));

    $this->assertEquals(true, $rule->evaluate($context));
    $rule->execute($context);
    $this->assertEquals('Correct', $message);
  }

}

<?php

class GameTest extends PHPUnit_Framework_TestCase {

  public function setUp() {
    $this->dataSource = \Mockery::mock('\PowerGrid\Interfaces\GameData');
    $this->dataSource
      ->shouldReceive('getPlayers')
      ->andReturn(array());
    $this->dataSource
      ->shouldReceive('getStepNumber')
      ->andReturn(0);
    $this->dataSource
      ->shouldReceive('save');

    $this->gameProgression = \Mockery::mock('\PowerGrid\Abstracts\GameProgression');

    $this->propositions = \Mockery::mock('\PowerGrid\Propositions');

    $this->rules = \Mockery::mock('rules');
    $this->rules
      ->shouldReceive('execute')
      ->andReturn(NULL);
    $this->rules
      ->shouldReceive('getLastExecutionStatus')
      ->andReturn(TRUE);

    $this->ruleFactory = \Mockery::mock('\PowerGrid\Factories\RuleFactory');
    $this->ruleFactory
      ->shouldReceive('makeRules')
      ->andReturn($this->rules);

    $this->event = \Mockery::mock('alias:PowerGrid\Structures\Event');
    $this->event
      ->shouldReceive('create')
      ->andReturn(\Mockery::self());
  }

  public function tearDown() {
    \Mockery::close();
  }

  public function testStartBidExecutesRules() {
    $rules = \Mockery::mock('rules');
    $rules
      ->shouldReceive('execute')
      ->once()
      ->andReturn(NULL);

    $rules
      ->shouldReceive('getLastExecutionStatus');

    $ruleFactory = \Mockery::mock('\PowerGrid\Factories\RuleFactory');
    $ruleFactory
      ->shouldReceive('makeRules')
      ->andReturn($rules);

    $game = new \HTTPPowerGrid\Game($this->dataSource, $this->gameProgression, $ruleFactory, $this->propositions);

    $player = \Mockery::mock('\PowerGrid\Interfaces\PlayerData');
    $powerPlant = \Mockery::mock('\PowerGrid\Interfaces\PowerPlantData');
    $bid = 0;

    $game->startBid($player, $powerPlant, $bid);
  }

  public function testStartBidNotifiesObservers() {
    $observer = \Mockery::mock('\PowerGrid\Interfaces\Observer');
    $observer
      ->shouldReceive('notify')
      ->once();

    $game = new \HTTPPowerGrid\Game($this->dataSource, $this->gameProgression, $this->ruleFactory, $this->propositions);
    $game->subscribe($observer);

    $player = \Mockery::mock('\PowerGrid\Interfaces\PlayerData');
    $powerPlant = \Mockery::mock('\PowerGrid\Interfaces\PowerPlantData');
    $bid = 0;

    $game->startBid($player, $powerPlant, $bid);
  }

  public function testStartBidSetsEventStatusCorrectly() {
    
  }
}

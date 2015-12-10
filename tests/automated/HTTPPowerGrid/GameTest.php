<?php

class GameTest extends PHPUnit_Framework_TestCase {

  public function tearDown() {
    \Mockery::close();
  }

  public function testStartBidExecutesRules() {
    $dataSource = \Mockery::mock('\PowerGrid\Interfaces\GameData');
    $dataSource
      ->shouldReceive('getPlayers')
      ->andReturn(array());
    $dataSource
      ->shouldReceive('getStepNumber')
      ->andReturn(0);
    $dataSource
      ->shouldReceive('save');

    $gameProgression = \Mockery::mock('\PowerGrid\Abstracts\GameProgression');

    $rules = \Mockery::mock('rules');
    $rules
      ->shouldReceive('execute')
      ->once();

    $ruleFactory = \Mockery::mock('\PowerGrid\Factories\RuleFactory');
    $ruleFactory
      ->shouldReceive('makeRules')
      ->once()
      ->andReturn($rules);

    $event = \Mockery::mock('alias:PowerGrid\Structures\Event');
    $event
      ->shouldReceive('create')
      ->andReturn(NULL);

    $propositions = \Mockery::mock('\PowerGrid\Propositions');

    $game = new \HTTPPowerGrid\Game($dataSource, $gameProgression, $ruleFactory, $propositions);

    $player = \Mockery::mock('\PowerGrid\Interfaces\PlayerData');
    $powerPlant = \Mockery::mock('\PowerGrid\Interfaces\PowerPlantData');
    $bid = 0;

    $game->startBid($player, $powerPlant, $bid);
  }
}

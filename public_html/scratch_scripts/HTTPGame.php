<?php

require('../../bootstrap.php');

$gameData = new \HTTPPowerGrid\GameData();

$ruleFactory = new \PowerGrid\Factories\RuleFactory();

$playerData = new \Player();

for ($i = 0; $i < 6; $i++) {
  $player = new \HTTPPowerGrid\Player($playerData->getId());
  $player->save();

  $gameData->addPlayer($player);
}


$game = new \HTTPPowerGrid\Game($gameData, $ruleFactory, array($player));

$game->determineTurnOrder();

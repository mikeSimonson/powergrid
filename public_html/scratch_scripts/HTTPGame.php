<?php

require('../../bootstrap.php');

$gameData = new \HTTPPowerGrid\GameData();

$ruleFactory = new \PowerGrid\Factories\RuleFactory();

$playerData = new \Player();

$player = new \HTTPPowerGrid\Player($playerData->getId());

$game = new \HTTPPowerGrid\Game($gameData, $ruleFactory, array($player));

$game->determineTurnOrder();

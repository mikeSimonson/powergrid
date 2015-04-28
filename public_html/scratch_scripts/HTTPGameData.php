<?php

require('../../bootstrap.php');

$gameData = new \HTTPPowerGrid\GameData();

for ($i = 0; $i < 6; $i++) {
  $player = new Player();
  $player->save();
  $gameData->addPlayer($player);
}

$gameData->save();

var_dump($gameData->getPlayers());

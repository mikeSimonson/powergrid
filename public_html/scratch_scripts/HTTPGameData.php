<?php

require('../../bootstrap.php');

$gameData = new \HTTPPowerGrid\GameData();

for ($i = 0; $i < 6; $i++) {
  $player = new Player();
  $player->setCurrentGame($gameData);
  $player->save();
}

$gameData->save();

var_dump($gameData->getPlayers());

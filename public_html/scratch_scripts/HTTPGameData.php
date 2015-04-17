<?php

require('../../bootstrap.php');

$gameData = new \HTTPPowerGrid\GameData();

$gameData->save();

var_dump($gameData->getId());

$existingGameData = new GameQuery();

$game2 = $existingGameData->findPK(2);

var_dump($game2->getTurnNumber());

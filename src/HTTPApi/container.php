<?php

$HTTPApiContainer = new \Pimple\Container();

$HTTPApiContainer['playerId'] = NULL;
$HTTPApiContainer['powerPlantCardId'] = NULL;
$HTTPApiContainer['userToken'] = NULL;

$HTTPApiContainer['powerPlant'] = function($c) {
  return \HTTPPowerGrid\Services\CardServices::findCardById($c['powerPlantCardId']);
};

$HTTPApiContainer['user'] = function($c) {
  return \HTTPPowerGrid\Services\UserServices::getUserByToken($c['userToken']);
};

$HTTPApiContainer['player'] = function($c) {
  return \HTTPPowerGrid\Services\PlayerServices::findPlayerById($c['playerId']);
};

$HTTPApiContainer['userPlayerServices'] = function($c) {
  return new \HTTPPowerGrid\Services\UserPlayerServices($c['user'], $c['player']);
};

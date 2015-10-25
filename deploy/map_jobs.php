<?php

require_once('../bootstrap.php');

function installMaps() {
  $gameconfigDir = '../gameconfig';
  $mapsFile = file_get_contents("$gameconfigDir/maps.json");
  $mapsFile = json_decode($mapsFile, TRUE);

  foreach ($mapsFile as $mapConfig) {
    $mapConfigParser = new \PowerGrid\Services\Config\MapConfigParser($mapConfig);
    $mapConfig = $mapConfigParser->parse();

    $connectionsConfigFile = $gameconfigDir . '/' . $mapConfig['filenames']['connections'];
    $citiesConfigFile = $gameconfigDir . '/' . $mapConfig['filenames']['cities'];

    $connectionsConfigFile = file_get_contents($connectionsConfigFile);
    $connectionsConfigFile = json_decode($connectionsConfigFile, TRUE);
    $connectionsConfig = new \PowerGrid\Services\Config\CityConnectionsConfigParser($connectionsConfigFile);
    $connectionsConfig = $connectionsConfig->parse();

    $citiesConfigFile = file_get_contents($citiesConfigFile);
    $citiesConfigFile = json_decode($citiesConfigFile, TRUE);
    $citiesConfig = new \PowerGrid\Services\Config\CitiesConfigParser($citiesConfigFile);
    $citiesConfig = $citiesConfig->parse();

    $install = new \HTTPPowerGrid\Install\MapInstall($mapConfig, $citiesConfig, $connectionsConfig);
    $install->performInstall();
  }
}

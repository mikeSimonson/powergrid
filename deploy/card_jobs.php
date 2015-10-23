<?php

function installCardSets() {
  $gameconfigDir = '../gameconfig';

  $cardSetsFile = file_get_contents("$gameconfigDir/card_sets.json");
  $cardSetsConfig = json_decode($cardSetsFile, TRUE);
  $cardSetsConfigParser = new \PowerGrid\Services\Config\CardSetsConfigParser($cardSetsConfig);
  $cardSetsConfig = $cardSetsConfigParser->parse();

  foreach ($cardSetsConfig AS $cardSetConfig) {
    $installer = new \HTTPPowerGrid\Install\CardSetInstall($cardSetConfig);
    $installer->installCardSet();
  }
}

function installResources() {
  $gameconfigDir = '../gameconfig';
  $resourceTypesFile = file_get_contents("$gameconfigDir/resource_types.json");
  $resourceTypesConfig = json_decode($resourceTypesFile);
  $resourceTypesConfigParser = new \PowerGrid\Services\Config\ResourceTypesConfigParser($resourceTypesConfig);
  $resourceTypesConfig = $resourceTypesConfigParser->parse();

  $installer = new \HTTPPowerGrid\Install\ResourceTypesInstall($resourceTypesConfig);
  $resourceTypesConfigToDBMap = $installer->installResources();

  return $resourceTypesConfigToDBMap;
}

function installCards() {

}

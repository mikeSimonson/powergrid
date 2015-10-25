<?php

$cardSetFileNameToDB = array();
$resourceTypesConfigToDBMap = array();

function installCardSets() {
  global $cardSetFileNameToDB;

  $gameconfigDir = '../gameconfig';

  $cardSetsFile = file_get_contents("$gameconfigDir/card_sets.json");
  $cardSetsConfig = json_decode($cardSetsFile, TRUE);
  $cardSetsConfigParser = new \PowerGrid\Services\Config\CardSetsConfigParser($cardSetsConfig);
  $cardSetsConfig = $cardSetsConfigParser->parse();

  foreach ($cardSetsConfig AS $cardSetConfig) {
    $installer = new \HTTPPowerGrid\Install\CardSetInstall($cardSetConfig);
    $installer->installCardSet();
    $cardSetFileNameToDB[$cardSetConfig->filename] = $installer->getInstalledCardSet();
  }
}

function installResources() {
  global $resourceTypesConfigToDBMap;

  $gameconfigDir = '../gameconfig';
  $resourceTypesFile = file_get_contents("$gameconfigDir/resource_types.json");
  $resourceTypesConfig = json_decode($resourceTypesFile);
  $resourceTypesConfigParser = new \PowerGrid\Services\Config\ResourceTypesConfigParser($resourceTypesConfig);
  $resourceTypesConfig = $resourceTypesConfigParser->parse();

  $installer = new \HTTPPowerGrid\Install\ResourceTypesInstall($resourceTypesConfig);
  $resourceTypesConfigToDBMap = $installer->installResources();
}

function installCards() {
  global $cardSetFileNameToDB;
  global $resourceTypesConfigToDBMap;

  $gameconfigDir = '../gameconfig';

  $cardSetsFile = file_get_contents("$gameconfigDir/card_sets.json");
  $cardSetsConfig = json_decode($cardSetsFile, TRUE);
  $cardSetsConfigParser = new \PowerGrid\Services\Config\CardSetsConfigParser($cardSetsConfig);
  $cardSetsConfig = $cardSetsConfigParser->parse();

  foreach ($cardSetFileNameToDB AS $cardsPath => $cardSet) {
    $cardsFile = file_get_contents("$gameconfigDir/$cardsPath");
    $cardsConfig = json_decode($cardsFile);
    $cardsConfigParser = new \PowerGrid\Services\Config\CardsConfigParser($cardsConfig);
    $cardsConfig = $cardsConfigParser->parse();

    $installer = new \HTTPPowerGrid\Install\CardsInstall($cardsConfig, $cardSet, $resourceTypesConfigToDBMap);
    $installer->installCards();
  }
}

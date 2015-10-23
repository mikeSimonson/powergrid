<?php

namespace HTTPPowerGrid\Install;

class ResourceTypesInstall {
  protected $cardSet;
  protected $config;
  protected $resourceTypesConfigToDBMap;

  public function __construct($resourceTypesConfig, \CardSet $cardSet) {
    $this->cardSet = $cardSet;
    $this->config = $resourceTypesConfig;
  }

  public function installResources() {
    foreach (array_keys($this->config) AS $resourceTypeKey) {
      $dbResourceType = new \ResourceType();
      $dbResourceType->setName($this->config[$resourceTypeKey]);
      $dbResourceType->setCardSet($this->cardSet);
      $dbResourceType->save();
      $this->resourceTypesConfigToDBMap[$resourceTypeKey] = $dbResourceType;
    }
  }

  public function getResourceTypesConfigToDBMap() {
    return $this->resourceTypesConfigToDBMap;
  }
}

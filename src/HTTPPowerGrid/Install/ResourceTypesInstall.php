<?php

namespace HTTPPowerGrid\Install;

class ResourceTypesInstall {
  protected $config;
  protected $resourceTypesConfigToDBMap;

  public function __construct($resourceTypesConfig) {
    $this->config = $resourceTypesConfig;
  }

  public function installResources() {
    foreach (array_keys($this->config) AS $resourceTypeKey) {
      $dbResourceType = new \ResourceType();
      $dbResourceType->setName($this->config[$resourceTypeKey]);
      $dbResourceType->save();
      $this->resourceTypesConfigToDBMap[$resourceTypeKey] = $dbResourceType;
    }
  }

  public function getResourceTypesConfigToDBMap() {
    return $this->resourceTypesConfigToDBMap;
  }
}

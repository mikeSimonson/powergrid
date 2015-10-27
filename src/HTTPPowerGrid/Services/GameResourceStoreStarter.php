<?php

namespace HTTPPowerGrid\Services;

class GameResourceStoreStarter extends \PowerGrid\Abstracts\GameResourceStoreStarter {
  protected function addResourceToGame($name, $quantity) {
    $resourceType = $this->getResourceTypeByName($name);
    $resourceStore = new \ResourceStore();
    $resourceStore->setQuantity($quantity);
    $resourceStore->setGame($this->game);
    $resourceStore->setResourceType($resourceType);
    $resourceStore->save();
  }

  protected function getResourceTypeByName($name) {
    $resourceType = \ResourceTypeQuery::create()
      ->findOneByName($name);

    if (is_null($resourceType)) {
      throw new \HTTPPowerGrid\Exceptions\Application\CouldNotFindDBObject("Could not find ResourceType with name $name");
    }

    return $resourceType;
  }
}

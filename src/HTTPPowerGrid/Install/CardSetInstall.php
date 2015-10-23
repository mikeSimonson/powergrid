<?php

namespace HTTPPowerGrid\Install;

class CardSetInstall {
  protected $cardSetName;
  protected $installedCardSet;

  public function __construct($cardSetName) {
    $this->cardSetName = $cardSetName;
  }

  public function installCardSet() {
    $cardSet = new \CardSet();
    $cardSet->setName($this->cardSetName);
    $cardSet->save();
    $this->installedCardSet = $cardSet;
  }

  public function getInstalledCardSet() {
    return $this->installedCardSet;
  }
}

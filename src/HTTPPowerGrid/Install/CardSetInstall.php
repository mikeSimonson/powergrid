<?php

namespace HTTPPowerGrid\Install;

class CardSetInstall {
  protected $cardSetConfig;
  protected $installedCardSet;

  public function __construct($cardSetConfig) {
    $this->cardSetConfig = $cardSetConfig;
  }

  public function installCardSet() {
    $cardSet = new \CardSet();
    $cardSet->setName($this->cardSetConfig['name']);
    $cardSet->save();
    $this->installedCardSet = $cardSet;
  }

  public function getInstalledCardSet() {
    return $this->installedCardSet;
  }
}

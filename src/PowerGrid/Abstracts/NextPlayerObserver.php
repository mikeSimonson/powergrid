<?php

class NextPlayerObserver implements \PowerGrid\Interfaces\Observer {

  protected $eventNamespace;
  protected $validEventNames = array();

  public function __construct(\PowerGrid\Interfaces\GameData $game) {
    $this->generateValidEventNames();
    $this->eventNamespace = \PowerGrid\Abstracts\Game::EVENT_NAMESPACE;
  }

  public function notify(\PowerGrid\Structures\Event $event) {
    if ($this->validEventNames[$event->getName()] && $event->getNamespace() === $this->eventNamespace) {
      $this->setNextPlayer($event);
    }
  }

  protected function generateValidEventNames() {
    $validActions = array(
      \PowerGrid\Interfaces\GameData::PASS_ON_BID_ACTION,
      \PowerGrid\Interfaces\GameData::BUY_RESOURCES_ACTION,
      \PowerGrid\Interfaces\GameData::BUILD_CITIES_ACTION,
      \PowerGrid\Interfaces\GameData::POWER_CITIES_ACTION
    );

    foreach ($validActions AS $validAction) {
      $eventName = $validAction . \PowerGrid\Abstracts\Game::ACTION_COMPLETE_EVENT_POSTFIX;
      $this->validEventNames[$eventName] = TRUE;
    }
  }

  protected function setNextPlayer(\PowerGrid\Structures\Event $eventObj) {
    
  }
}

<?php

namespace HTTPPowerGrid\Services;

class PropositionLoader extends \HTTPPowerGrid\Abstracts\ContainerLoader {
  static $propositions = array(
    'IsPlayersTurn',
    'PlayerHasEnoughMoneyForBid',
    'UserIsLoggedIn'
  );

  static public function load(\Container $propositionContainer) {
    $propositionContainer->addNamespace('\HTTPPowerGrid\Propositions');
    $propositionContainer->addNamespace('\PowerGrid\Propositions');

    foreach (static::$propositions AS $className) {
      static::registerClassWithSameReferenceName($propositionContainer, $className);
    }
  }
}

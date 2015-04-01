<?php

namespace \PowerGrid\Interfaces\ActionRulset;

interface ActionRuleset {

  public function __construct();

  public function execute(\PowerGrid\Interfaces\GameData $gameData, \Ruler\Context $turnData);

}

<?php

namespace PowerGrid\Abstracts;

abstract class ConfigParser {
  protected $contents;
  protected $preMangle;

  public function __construct($currentConfig) {
    $this->preMangle = $currentConfig;
  }

  public function parse() {
    $this->checkValidity();
    return $this->mangle();
  }

  /**
   * Throw any errors in the format of the config.
   */
  abstract protected function checkValidity();

  /**
   * Parse the current config into the one this parser is meant to produce.
   */
  abstract protected function mangle();
}

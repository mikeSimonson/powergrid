<?php

namespace HTTPPowerGrid\Abstracts;

abstract class ContainerLoader implements \PowerGrid\Interfaces\ContainerLoader {
  static abstract public function load(\Container $propositionContainer);

  static protected function registerClassWithSameReferenceName(\Container $container, $className) {
    $container->register($className, $className);
  }
}

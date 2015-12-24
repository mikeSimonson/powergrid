<?php

class ContainerTest extends PHPUnit_Framework_TestCase {
  public function testContainerCreatesClass() {
    $c = new \PowerGrid\Container;
    $c->register('stdClass', 'testRegistration');
    $c->addNamespace('');
    $this->assertInstanceOf('stdClass', $c->testRegistration());
  }
}

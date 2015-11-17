<?php

namespace PowerGrid;

class Container implements \PowerGrid\Interfaces\Singleton {

  static protected $instance;

  protected $registry = array();

  protected $namespaces = array();

  static public function instance() {
    if (is_null(static::$instance)) {
      static::$instance = new static();
    }

    return static::$instance;
  }

  public function register($className, $referenceName) {
    $this->registry[$referenceName] = $className;
  }

  /**
   * Namespaces added earlier will be attempted first for name resolution.
   * There is no default case for classes that are already namespaced. If you 
   * plan to have your classes already namespaced when you attempt to retrieve 
   * them, add only the namespace ''.
   *
   */
  public function addNamespace($namespace) {
    $this->namespaces[] = $namespace;
  }

  /**
   * Arguments is ignored.
   */
  public function __call($referenceName, $arguments) {
    var_dump($referenceName);
    if (!is_string($this->registry[$referenceName])) {
      throw new \PowerGrid\Exceptions\Application\ClassNotRegisteredOnContainer($referenceName, __CLASS__);
    }

    $resolvedClassName = $this->prependNamespace($this->registry[$referenceName]);

    return new $resolvedClassName();
  }

  protected function prependNamespace($className) {
    $classFound = FALSE;
    $i = 0;

    while (!$classFound && $i < count($this->namespaces)) {
      $qualifiedName = $this->namespaces[$i] . '\\' . $className;
      if (class_exists($qualifiedName)) {
        $classFound = TRUE;
      }
      ++$i;
    }

    if (!$classFound) {
      throw new \PowerGrid\Exceptions\Application\RegisteredClassDoesNotExistInContainer($className, __CLASS__);
    }

    return $qualifiedName;
  }
}

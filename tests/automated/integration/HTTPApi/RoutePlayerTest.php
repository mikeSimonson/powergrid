<?php

class PlayerTest extends PHPUnit_Extensions_Database_TestCase {

  public function testTest() {
    $user = new \User();
    $user->setName('eddie');
    $user->setUsername('eddie');
    $user->setEmail('eddie@eddie.com');
    $hashed_password = password_hash('eddie', PASSWORD_DEFAULT);
    $user->setPassword($hashed_password);
    $user->save();
  }

  public function getConnection() {
    $dsn = 'sqlite:' . TEST_SQLITE3_DB_FILENAME;
    $pdo = new PDO($dsn);
    return $this->createDefaultDBConnection($pdo, 'powergrid');
  }

  public function getDataSet() {
    return $this->createFlatXMLDataSet(dirname(__FILE__).'/_files/empty-database.xml');
  }

}

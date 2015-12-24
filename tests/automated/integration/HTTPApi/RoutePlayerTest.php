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
    var_dump(TEST_SQLITE3_DB_FILENAME);
  }

  public function getConnection() {
    $dsn = 'sqlite:' . TEST_SQLITE3_DB_FILENAME;
    var_dump($dsn);
    $pdo = new PDO($dsn);
    var_dump(TEST_SQLITE3_DB_FILENAME);
    return $this->createDefaultDBConnection($pdo, 'powergrid');
  }

  public function getDataSet() {
    var_dump(TEST_SQLITE3_DB_FILENAME);
    return $this->createFlatXMLDataSet(dirname(__FILE__).'/_files/empty-database.xml');
  }

}

<?php

require_once(BASE_DIR . '/tests/automated/integration/stubs/ValidUserRegisterRequestStub.php');
require_once(BASE_DIR . '/tests/automated/integration/stubs/Response.php');

class HandlerUserTest extends PHPUnit_Extensions_Database_TestCase {

  public function testRegisterHandlerAcceptsValidUserNameAndPassword() {
    $app = new stdClass();
    $app->request = new \Tests\Stubs\ValidUserRegisterRequestStub();
    $app->request->username = 'username1';
    $app->request->email = 'test@test.com';
    $app->request->password = 'Password1$';
    $app->request->name = 'testuser';

    $app->response = new \Tests\Stubs\Response();

    $json_result = \Mockery::mock();
    $json_result
      ->shouldReceive('addError');
    $json_result
      ->shouldReceive('setSuccess');
    $json_result
      ->shouldReceive('noErrors')
      ->andReturn(TRUE);
    $json_result
      ->shouldReceive('getJSON')
      ->andReturn('');

    $handler = \HTTPApi\Handlers\User::register($app, $json_result);

    $handler($app, $json_result);

    $this->assertEquals($app->response->status, 200);
  }

  public function testRegisterHandlerCreatesUserWithCorrectProperties() {
    $app = new stdClass();
    $app->request = new \Tests\Stubs\ValidUserRegisterRequestStub();
    $app->request->username = 'username1';
    $app->request->email = 'test@test.com';
    $app->request->password = 'Password1$';
    $app->request->name = 'testuser';

    $app->response = new \Tests\Stubs\Response();

    $json_result = \Mockery::mock();
    $json_result
      ->shouldReceive('addError');
    $json_result
      ->shouldReceive('setSuccess');
    $json_result
      ->shouldReceive('noErrors')
      ->andReturn(TRUE);
    $json_result
      ->shouldReceive('getJSON')
      ->andReturn('');

    $handler = \HTTPApi\Handlers\User::register($app, $json_result);

    $handler($app, $json_result);

    $dsn = 'sqlite:' . TEST_SQLITE3_DB_FILENAME;
    $conn = new PDO($dsn);

    $result = $conn->query(
      'SELECT COUNT(id) AS "userCount" FROM user'
    );

    $this->assertEquals(1, $result->fetchColumn(0), 'Should create only one user');

    $result = $conn->query(
      "SELECT * FROM user WHERE username = 'username1'"
    );

    $createdUser = $result->fetch(PDO::FETCH_ASSOC);

    $this->assertEquals($app->request->username, $createdUser['username']);
    $this->assertEquals($app->request->email, $createdUser['email']);
    $this->assertEquals($app->request->name, $createdUser['name']);
    $this->assertTrue(password_verify($app->request->password, $createdUser['password']));
  }

  public function getConnection() {
    $dsn = 'sqlite:' . TEST_SQLITE3_DB_FILENAME;
    $conn = new PDO($dsn);

    return $this->createDefaultDBConnection($conn, 'powergrid');
  }

  public function getDataSet() {
    return $this->createFlatXMLDataSet(dirname(dirname(__FILE__)).'/_files/empty-database.xml');
  }
}

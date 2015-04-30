<?php

use Symfony\Component\HttpFoundation\Response as HTTPResponse;

$app->group('/user', function () use ($app, $json_result) {

  $app->post('/register', function() use ($app, $json_result) {
    $expected_indices = array('username', 'password', 'email');

    $input_map = array(
      'username' => $app->request->post('username'),
      'password' => $app->request->post('password'),
      'email' => $app->request->post('email')
    );

    foreach ($input_map AS $input) {
      if (empty($input)) {
        $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
        $json_result->addError('Expected name, username, password, and email.');
        $app->response->setBody($json_result->getJSON());
        return;
      }
    }

    $username = $app->request->post('username');
    $password = $app->request->post('password');
    $email = $app->request->post('email');
    $name = !is_null($app->request->post('name')) ? $app->request->post('name') : $app->request->post('username');

    $name_min_len = 3;
    $name_max_len = 40;
    $name_pcre_range = '{' . $name_min_len . ',' . $name_max_len . '}';
    $name_match_pattern = '/^\w' . $name_pcre_range . '$/';

    $username_min_len = 3;
    $username_max_len = 40;
    $username_pcre_range = '{' . $username_min_len . ',' . $username_max_len . '}';
    $username_match_pattern = '/^\w' . $username_pcre_range . '$/';

    $pwd_special_chars = '!@#$%^&*()';
    $pwd_min_len = 8;
    $pwd_max_len = 40;
    $pwd_pcre_range = '{' . $pwd_min_len . ',' . $pwd_max_len . '}';
    $pwd_match_pattern = '/^[\w' . $pwd_special_chars . ']' . $pwd_pcre_range . '$/i';

    //@todo: make sure username is not already taken

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $json_result->addError('Invalid email address.');
    }
    else {
      $existingUser = \UserQuery::create()->findOneByEmail($email);
      if ($existingUser instanceof \User) {
        $json_result->addError("Email must be unique. $email already exists.");
      }
    }
    
    if (!preg_match($username_match_pattern, $username)) {
      $json_result->addError("Invalid username. Must contain only alphanumerics and '_' and be between $username_min_len and $username_max_len chars.");
    }
    else {
      $existingUser = \UserQuery::create()->findOneByUserName($username);
      if ($existingUser instanceof \User) {
        $json_result->addError("Username must be unique. $username already exists.");
      }
    }

    if (!preg_match($pwd_match_pattern, $password)) {
      $json_result->addError("Invalid password. Can only contain chars A-Z, a-z, 0-9, and the special chars $pwd_special_chars. Must be between $pwd_min_len and $pwd_max_len chars.");
    }

    if (!preg_match($name_match_pattern, $name)) {
      $json_result->addError("Invalid name. Must contain only alphanumerics and '_' and be between $name_min_len and $name_max_len chars.");
    }

    if ($json_result->noErrors()) {
      $user = new \User();
      $user->setName($name);
      $user->setUsername($username);
      $user->setEmail($email);
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $user->setPassword($hashed_password);
      $user->save();
      $json_result->setSuccess('Username ' . $username . ' has been created.');
      // Do username operation
    }

    $app->response->setStatus(HTTPResponse::HTTP_OK);
    $app->response->setBody($json_result->getJSON());
  });
});

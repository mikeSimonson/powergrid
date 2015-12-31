<?php

require_once('../bootstrap.php');

use Symfony\Component\HttpFoundation\Response as HTTPResponse;

$app->group('/user', function () use ($app, $json_result) {

  $app->post('/register', \HTTPApi\Handlers\User::register($app, $json_result));

  $app->post('/login', function() use($app, $json_result) {
    $username = $app->request->post('username');
    $password = $app->request->post('password');

    // Ensure that we got a username and password.
    $input_map = array(
      'username' => $username,
      'password' => $password
    );
    foreach ($input_map AS $input) {
      if (empty($input)) {
        $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
        $json_result->addError('Expected username and password.');
        $app->response->setBody($json_result->getJSON());
        return;
      }
    }

    // Validate username and password
    $q = \UserQuery::create();
    $user = $q->findOneByUsername($username);
    if (is_null($user) || !password_verify($password, $user->getPassword())) {
      $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
      $json_result->addError('Username or password not found/incorrect.');
      $app->response->setBody($json_result->getJSON());
      return;
    }

    // Get the existing token or generate a new one based on timestamp.
    $q = \UserTokenQuery::create();
    $userToken = $q->findOneByTokenUser($user);
    if ($userToken instanceof \UserToken) {
      $userToken->delete();
    }

    $userToken = new \UserToken();
    $userToken->setTokenUser($user);
    $userToken->generateNewToken();
    $userToken->save();
    
    $returnToken = $userToken->getTokenString();
    $expirationTimestamp = $userToken->getExpirationDate()->getTimestamp();

    // All good. Send the token information along.
    $json_result->setSuccess('Valid credentials.');
    $json_result->addData('token', $returnToken);
    $json_result->addData('expires', $expirationTimestamp);
    $app->response->setStatus(HTTPResponse::HTTP_OK);
    $app->response->setBody($json_result->getJSON());
    return;
  });

  // Used if the user already has an account, and wants to manage it.
  $app->group('/account', function() use ($app, $json_result) {
  }); // END /user/account endpoint
});

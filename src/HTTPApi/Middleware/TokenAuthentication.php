<?php

namespace HTTPApi\Middleware;

use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class TokenAuthentication extends \Slim\Middleware {

  protected $json_result;
  
  public function __construct($json_result) {
    $this->json_result = $json_result;
  }

  public function call() {
    $token = $this->app->request->params('token');
    $uriRoute = $this->app->request->getResourceUri();
    $success = TRUE;

    if ($this->uriRouteRequiresToken($uriRoute) === TRUE) {
      if ($this->gaveAuthenticationToken($token) === FALSE) {
        $this->app->response->setStatus(HTTPResponse::HTTP_UNAUTHORIZED);
        $this->json_result->addError('No authentication token provided. (param: token)'); $this->app->response->setBody($this->json_result->getJSON());
        $success = FALSE;
      }
      else if ($this->isTokenValid($token) === FALSE){
        $this->app->response->setStatus(HTTPResponse::HTTP_UNAUTHORIZED);
        $this->json_result->addError('Invalid authentication token. (param: token)');
        $this->app->response->setBody($this->json_result->getJSON());
        $success = FALSE;
      }
    }

    if ($success === TRUE) {
      $this->next->call();
    }
  }

  protected function gaveAuthenticationToken($tokenParam) {
    $gaveToken = TRUE;
    if (empty($tokenParam)) {
      $gaveToken = FALSE;
    }

    return $gaveToken;
  }

  protected function isTokenValid($token) {
    $isValidToken = TRUE;

    $q = \UserTokenQuery::create();
    $userToken = $q->findOneByTokenString($token);
    if (is_null($userToken)) {
      $isValidToken = FALSE;
    }
    else {
      $expiryDate = $userToken->getExpirationDate();
      $now = new \DateTime();
      if ($expiryDate < $now) {
        $isValidToken = FALSE;
      }
    }

    return $isValidToken;
  }

  protected function uriRouteRequiresToken($route) {
    $requiresToken = TRUE;
    $noTokenRoutes = array(
      '/user/register',
      '/user/login'
    );

    if (in_array($route, $noTokenRoutes)) {
      $requiresToken = FALSE;
    }

    return $requiresToken;
  }
}

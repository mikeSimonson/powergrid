<?php

namespace HTTPApi\Middleware;

class TokenAuthentication extends \Slim\Middleware {

  public function call() {
    $token = $this->app->request->params('token');
    $uriRoute = $this->app->request->getResourceUri();
    $success = TRUE;

    if ($this->uriRouteRequiresToken($uriRoute) === TRUE) {
      if ($this->gaveAuthenticationToken($token)) {
        $this->app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
        $json_result->addError('No authentication token provided. (param: token)');
        $this->app->response->setBody($json_result->getJSON());
        $success = FALSE;
      }
      else if ($this->isTokenValid($token) === FALSE){
        $this->app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
        $json_result->addError('Invalid authentication token. (param: token)');
        $this->app->response->setBody($json_result->getJSON());
        $success = FALSE;
      }
    }

    if ($success = )
    $this->next();
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

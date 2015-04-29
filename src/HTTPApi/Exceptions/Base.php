<?php

namespace HTTPApi\Exceptions;

class Base extends \Exception {

  const API_ERROR_PREFIX = '<html><head></head><body><h1>POWERGRID HTTP API</h1><h2>You done fucked it up.</h2><p>';
  const API_ERROR_POSTFIX = '</p></body></html>';

}

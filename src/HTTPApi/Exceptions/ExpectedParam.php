<?php

namespace HTTPApi\Exceptions;

class ExpectedParam extends \HTTPApi\Exceptions\Base {

  const EXPECTED_PARAM_ERROR_PREFIX = 'Expected parameters ';
  const EXPECTED_PARAM_ERROR_POSTFIX = '. You should probably send those.';

  public function __construct($input_map) {
    $bad_param_names = array();
    foreach ($input_map AS $param_name => $input) {
      if (empty($input)) {
        $bad_param_names[] = $param_name;
      }
    }

    parent::__construct();
  }

  protected function addExpectedParamErrorMsg($param_names) {
    $param_names = '"' . implode('", "', $param_names) . '"';

    $this->message = static::API_ERROR_PREFIX . static::EXPECTED_PARAM_ERROR_PREFIX . $param_names . static::EXPECTED_PARAM_ERROR_POSTFIX . static::API_ERROR_POSTFIX;
  }
}

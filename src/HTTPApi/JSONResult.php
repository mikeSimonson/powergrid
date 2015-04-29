<?php
namespace HTTPApi;

class JSONResult {
  const RESULT_ERROR = 'ERROR';
  const RESULT_SUCCESS = 'SUCCESS';

  const RESULT_STATUS_KEY = 'status';
  const RESULT_MESSAGE_KEY = 'message';
  const RESULT_ERRORS_KEY = 'errors';
  
  protected $reservedDataKeys = array();

  protected $status = null;
  protected $errors = array();
  protected $successMessage = array();
  protected $data = array();

  public function __construct() {
    $this->reservedDataKeys = array(
      static::RESULT_STATUS_KEY,
      static::RESULT_MESSAGE_KEY,
      static::RESULT_ERRORS_KEY
    );
  }

  public function addError($errorMsg) {
    if (!is_string($errorMsg)) {
      throw new \Exception("JSON result messages must be strings.");
    }

    $this->status = static::RESULT_ERROR;

    $this->errors[] = $errorMsg;
  }

  public function setSuccess($successMsg) {
    if (!$this->noErrors()) {
      throw new \Exception("Trying to set success on a JSON result when there are errors.");
    }

    if (!is_string($successMsg)) {
      throw new \Exception("JSON result messages must be strings.");
    }

    $this->status = static::RESULT_SUCCESS;
    $this->successMsg = $successMsg;
  }

  public function noErrors() {
    return ($this->status !== static::RESULT_ERROR) && (count($this->errors) == 0);
  }

  public function send() {
    $result = new \stdClass();

    $result->status = $this->status;

    if ($this->noErrors()) {
      $result->message = $this->successMsg;
    }
    else {
      $result->errors = $this->errors;
    }

    $result->data = $this->data;

    echo $this->JSONify($result);
  }

  public function addData($key, $value) {
    if (in_array($key, $this->reservedDataKeys)) {
      throw new \Exception('The following keys are reserved and may not be used in JSON result data: ' . implode(' ', $this->reserved_data_keys));
    }

    $this->data[$key] = $value;
  }

  public function JSONify($thing) {
    $json = json_encode($thing);

    if ($json === false) {
      throw new \Exception("JSON result only accepts jsonifiable things.");
    }

    return $json;
  }
}

?>

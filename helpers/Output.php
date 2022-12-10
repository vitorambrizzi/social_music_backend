<?php
class Output {
  static function response($array_response, $status_code = 200) {
    http_response_code($status_code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($array_response);
    die;
  }

  static function not_found() {
    $response['error']['message'] = 'API endpoint not found!';
    self::response($response, 404);
  }
}
?>
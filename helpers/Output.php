<?php
class Output {
  static function response($array_response, $status_code = 200) {
    http_response_code($status_code);
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: ' . ALLOWED_HOSTS);
    header('Access-Control-Allow-Methods: ' . ALLOWED_METHODS);
    header('Access-Control-Allow-Headers: ' . ALLOWED_HEADERS);
    echo json_encode($array_response);
    die;
  }

  static function not_found() {
    $result['error']['message'] = 'API endpoint not found!';
    self::response($result, 404);
  }
}
?>
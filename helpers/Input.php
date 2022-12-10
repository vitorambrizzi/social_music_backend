<?php
class Input {
  static function get_data() {
    $json_data = file_get_contents('php://input');
    return json_decode($json_data, true);
  }

  static function bcrypt($string, $cost = '10') {
    $options['cost'] = $cost;
    $hash = password_hash($string, PASSWORD_BCRYPT, $options);
    return $hash;
  }
}
?>
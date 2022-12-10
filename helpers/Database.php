<?php
class Database {
  static function connect() {
    $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;

    try {
      $conn = new PDO($dsn, DB_USER, DB_PASS);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      return $conn;
    } catch(PDOException $e) {
      self::db_error($e);
    }
  }

  static function db_error($error) {
    $result['error']['message'] = 'Server error, please try again!';
    $result['error']['database'] = $error;
    Output::response($result, 500);
  }
}
?>
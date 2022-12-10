<?php
class User {
  private $id;
  private $email;
  private $pass;

  function __construct($id, $email, $pass) {
    $this->id = $id;
    $this->email = $email;
    $this->pass = $pass;
  }

  function create() {
    $conn = Database::connect();

    try {
      $stmt = $conn->prepare("INSERT INTO users (email, pass) VALUES (:email, :pass);");
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':pass', $this->pass);
      $stmt->execute();

      $id = $conn->lastInsertId();
      $conn = null;
      return $id;
    } catch(PDOException $e) {
      Database::db_error($e);
    }
  }
}
?>
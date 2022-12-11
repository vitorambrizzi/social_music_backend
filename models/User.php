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

  function pass_check() {
    $conn = Database::connect();

    try {
      $stmt = $conn->prepare("SELECT pass FROM users WHERE email = :email;");
      $stmt->bindParam(':email', $this->email);
      $stmt->execute();

      $hash = $stmt->fetch(PDO::FETCH_ASSOC);
      $conn = null;

      return password_verify($this->pass, $hash['pass']);
    } catch(PDOException $e) {
      Database::db_error($e);
    }
  }

  function login() {
    $conn = Database::connect();

    try {
      $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email;");
      $stmt->bindParam(':email', $this->email);
      $stmt->execute();

      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      $conn = null;

      return $user;
    } catch(PDOException $e) {
      Database::db_error($e);
    }
  }
}
?>
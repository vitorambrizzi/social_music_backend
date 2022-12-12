<?php
class User {
  private $id;
  private $name;
  private $email;
  private $pass;

  function __construct($id, $name, $email, $pass) {
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->pass = $pass;
  }

  function create() {
    $conn = Database::connect();

    try {
      $stmt = $conn->prepare("INSERT INTO users (name, email, pass) VALUES (:name, :email, :pass);");
      $stmt->bindParam(':name', $this->name);
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

      if (is_array($hash)) {
        return password_verify($this->pass, $hash['pass']);
      } else {
        return false;
      }
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

  function get_by_id() {
    $conn = Database::connect();

    try {
      $stmt = $conn->prepare("SELECT name, email FROM users WHERE id = :id;");
      $stmt->bindParam(':id', $this->id);
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
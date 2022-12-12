<?php
class Session {
  private $id;
  private $id_user;
  private $token;
  private $client;

  function __construct($id, $id_user, $token, $client) {
    $this->id = $id;
    $this->id_user = $id_user;
    $this->token = $token;
    $this->client = $client;
  }

  function create() {
    $conn = Database::connect();

    try {
      $stmt = $conn->prepare("INSERT INTO sessions (id_user, token, client) VALUES (:id_user, :token, :client);");
      $stmt->bindParam(':id_user', $this->id_user);
      $stmt->bindParam(':token', $this->token);
      $stmt->bindParam(':client', $this->client);
      $stmt->execute();

      $id = $conn->lastInsertId();
      $conn = null;
      return $id;
    } catch(PDOException $e) {
      Database::db_error($e);
    }
  }

  function delete() {
    $conn = Database::connect();

    try {
      $stmt = $conn->prepare("DELETE FROM sessions WHERE id_user = :id_user AND token = :token;");
      $stmt->bindParam(':id_user', $this->id_user);
      $stmt->bindParam(':token', $this->token);
      $stmt->execute();

      $rows_affected = $stmt->rowCount();
      $conn = null;
      
      if ($rows_affected === 1) {
        return true;
      } else {
        return false;
      }
    } catch(PDOException $e) {
      Database::db_error($e);
    }
  }
}
?>
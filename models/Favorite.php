<?php
class Favorite {
  private $id;
  private $id_user;
  private $identifier;

  function __construct($id, $id_user, $identifier) {
    $this->id = $id;
    $this->id_user = $id_user;
    $this->identifier = $identifier;
  }

  function add($type) {
    $conn = Database::connect();

    try {
      $stmt = $conn->prepare("INSERT INTO $type (id_user, identifier) VALUES (:id_user, :identifier);");
      $stmt->bindParam(':id_user', $this->id_user);
      $stmt->bindParam(':identifier', $this->identifier);
      $stmt->execute();

      $id = $conn->lastInsertId();
      $conn = null;
      return $id;
    } catch(PDOException $e) {
      Database::db_error($e);
    }
  }

  function get_by_id($type) {
    $conn = Database::connect();

    try {
      $stmt = $conn->prepare("SELECT identifier FROM $type WHERE id_user = :id_user;");
      $stmt->bindParam(':id_user', $this->id_user);
      $stmt->execute();

      $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $conn = null;
      return $list;
    } catch(PDOException $e) {
      Database::db_error($e);
    }
  }

  function delete($type) {
    $conn = Database::connect();

    try {
      $stmt = $conn->prepare("DELETE FROM $type WHERE id_user = :id_user AND identifier = :identifier;");
      $stmt->bindParam(':id_user', $this->id_user);
      $stmt->bindParam(':identifier', $this->identifier);
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
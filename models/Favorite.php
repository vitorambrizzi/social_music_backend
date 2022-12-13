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
}
?>
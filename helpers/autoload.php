<?php
spl_autoload_register(
  function ($class_name) {
    if (file_exists(HELPERS_FOLDER . $class_name . '.php')) {
      require HELPERS_FOLDER . $class_name . '.php';
    }
  }
);
?>
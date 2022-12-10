<?php
spl_autoload_register(
  function ($file_name) {
    if (file_exists(CONTROLLERS_FOLDER . $file_name . '.php')) {
      require CONTROLLERS_FOLDER . $file_name . '.php';
    }
    if (file_exists(HELPERS_FOLDER . $file_name . '.php')) {
      require HELPERS_FOLDER . $file_name . '.php';
    }
    if (file_exists(MODELS_FOLDER . $file_name . '.php')) {
      require MODELS_FOLDER . $file_name . '.php';
    }
  }
);
?>
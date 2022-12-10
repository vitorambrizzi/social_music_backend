<?php
require 'config.php';
require HELPERS_FOLDER . 'autoload.php';

Router::gate_keeper();
Output::not_found();
?>
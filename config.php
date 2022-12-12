<?php
// CORS
define('ALLOWED_HOSTS', 'http://localhost:3000');
define('ALLOWED_METHODS', 'GET, POST, OPTIONS, DELETE, PUT');
define('ALLOWED_HEADERS', 'Accept, Content-Type');

// DATABASE
define('DB_NAME', 'social_music');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');

// PATHS AND FOLDERS
define('BASE_PATH', '/social_music/backend/');
define('CONTROLLERS_FOLDER', 'controllers/');
define('HELPERS_FOLDER', 'helpers/');
define('MODELS_FOLDER', 'models/');
?>
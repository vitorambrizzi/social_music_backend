<?php
class Router {
  static function gate_keeper() {
    self::handle_CORS();

    $uri = $_SERVER['REQUEST_URI'];
    $uri_clean = str_replace(BASE_PATH, '', $uri);
    $uri_segments = explode('/', $uri_clean);

    if (isset($uri_segments[0]) && $uri_segments[0] != '') {
      if (isset($uri_segments[1]) && $uri_segments[1] != '') {
        $controller = ucfirst($uri_segments[0]) . 'Controller';
        $remove_params = explode('?', $uri_segments[1]);
        $method = str_replace('-', '_', $remove_params[0]);

        if (file_exists(CONTROLLERS_FOLDER . $controller . '.php')) {
          if (method_exists($controller, $method)) {
            $controller::$method();
            die;
          }
        }
      }
    }
  }

  static function allowed_method($request_method) {
    if ($_SERVER['REQUEST_METHOD'] !== $request_method) {
      $result['error']['message'] = 'Method ' . $_SERVER['REQUEST_METHOD'] . ' not allowed for this route!';
      Output::response($result, 405);
    }
  }

  static function handle_CORS() {
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
      header('Access-Control-Allow-Origin: ' . ALLOWED_HOSTS);
      header('Access-Control-Allow-Methods: ' . ALLOWED_METHODS);
      header('Access-Control-Allow-Headers: ' . ALLOWED_HEADERS);
      die;
    }
  }
}
?>
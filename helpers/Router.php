<?php
class Router {
  static function gate_keeper() {
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
      $response['error']['message'] = 'Method ' . $_SERVER['REQUEST_METHOD'] . 'not allowed for this route!';
      Output::response($response, 405);
    }
  }
}
?>
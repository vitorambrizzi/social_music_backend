<?php
class AuthController {
  static function login() {
    Router::allowed_method('POST');

    $data = Input::get_data();
    $email = $data['email'];
    $pass = $data['pass'];

    $user = new User(null, $email, $pass);
    if ($user->pass_check()) {
      $user_logged = $user->login();
      $token = hash('sha256', uniqid(rand(), true));
      $client = $_SERVER['HTTP_USER_AGENT'];
      $session = new Session(null, $user_logged['id'], $token, $client);
      $session_id = $session->create();

      if ($session_id) {
        $result['success']['message'] = 'User logged in successfully!';
        $result['data']['id_user'] = $user_logged['id'];
        $result['data']['token'] = $token;
        Output::response($result);
      } else {
        $result['error']['message'] = 'Error creating session! Please, try again';
        Output::response($result, 500);
      }
    } else {
      $result['error']['message'] = 'Email or password invalid! Please, try again.';
      Output::response($result, 401);
    }

    $result['success']['message'] = 'User created successfully!';
    $result['user'] = $data;
    $result['user']['pass'] = $pass;
    $result['user']['id'] = $id;

    Output::response($result);
  }
}
?>
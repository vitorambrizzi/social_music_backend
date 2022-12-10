<?php
class UserController {
  static function test() {
    echo 'test';
  }

  static function sign_up() {
    Router::allowed_method('POST');

    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $user = new User(null, $email, $pass);
    $id = $user->create();

    $result['success']['message'] = 'User created successfully!';
    $result['user'] = $_POST;
    $result['user']['id'] = $id;
    Output::response($result);
  }
}
?>
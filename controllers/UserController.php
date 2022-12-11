<?php
class UserController {
  static function sign_up() {
    Router::allowed_method('POST');

    $data = Input::get_data();
    $email = $data['email'];
    $pass = Input::bcrypt($data['pass'], '12');

    $user = new User(null, $email, $pass);
    $id = $user->create();

    $result['success']['message'] = 'User created successfully!';
    $result['user'] = $data;
    $result['user']['pass'] = $pass;
    $result['user']['id'] = $id;

    Output::response($result);
  }
}
?>
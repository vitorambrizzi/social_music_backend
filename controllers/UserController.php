<?php
class UserController {
  static function sign_up() {
    Router::allowed_method('POST');

    $data = Input::get_data();
    $name = $data['name'];
    $email = $data['email'];
    $pass = Input::bcrypt($data['pass'], '12');

    $user = new User(null, $name, $email, $pass);
    $id = $user->create();

    $result['success']['message'] = 'User created successfully!';
    $result['user'] = $data;
    $result['user']['pass'] = $pass;
    $result['user']['id'] = $id;

    Output::response($result);
  }

  static function list() {
    Router::allowed_method('GET');

    $user = new User(null, null, null, null);
    $users_data = $user->get_list();

    if (empty($users_data)) {
      $result['success']['message'] = 'No users!';
      Output::response($result);
    } else {
      $result['success']['message'] = 'User list has been successfully selected!';
      $result['data'] = $users_data;
      Output::response($result);
    }
  }

  static function by_id() {
    Router::allowed_method('GET');

    if (isset($_GET['id'])) {
      $id = $_GET['id'];
    } else {
      $result['error']['message'] = 'Id parameter is required!';
      Output::response($result, 406);
    }

    $user = new User($id, null, null, null);
    $user_data = $user->get_by_id();

    if (is_array($user_data)) {
      $result['success']['message'] = 'User successfully selected!';
      $result['data'] = $user_data;
      Output::response($result);
    } else {
      $result['error']['message'] = 'User not found!';
      Output::response($result, 404);
    }
  }

  static function delete() {
    Router::allowed_method('DELETE');
    $data = Input::get_data();

    if (isset($data['id']) && $data['id'] != '') {
      $id = $data['id'];
    } else {
      $result['error']['message'] = 'Id parameter is required!';
      Output::response($result, 406);
    }

    $user = new User($id, null, null, null);
    $deleted = $user->delete();

    if ($deleted) {
      $result['success']['message'] = "User $id deleted successfully!";
      Output::response($result);
    } else {
      $result['error']['message'] = "User $id not found for deletion!";
      Output::response($result, 404);
    }
  }

  static function update() {
    Router::allowed_method('PUT');
    $data = Input::get_data();

    if (isset($data['id']) && $data['id'] != '') {
      $id = $data['id'];
    } else {
      $result['error']['message'] = 'Id parameter is required!';
      Output::response($result, 406);
    }
    $name = $data['name'];
    $email = $data['email'];

    $user = new User($id, $name, $email, null);
    $updated = $user->update();

    if ($updated) {
      $result['success']['message'] = 'User updated successfully!';
      $result['user'] = $data;
      Output::response($result);
    } else {
      $result['error']['message'] = "User $id not found for updates!";
      Output::response($result, 404);
    }
  }
}
?>
<?php
  class Favorite {
    static function add() {
      Router::allowed_method('POST');
      $data = Input::get_data();

      if (isset($data['type']) && $data['type'] != '') {
        $type = $data['type'];
      } else {
        $result['error']['message'] = 'Type parameter is required!';
        Output::response($result, 406);
      }
      $id_user = $data['id_user'];
      $identifier = $data['identifier'];

      $favorite = new Favorite(null, $id_user, $identifier);
      $id = $favorite->create($type);

      $result['success']['message'] = 'User created successfully!';
      $result['user'] = $data;
      $result['user']['pass'] = $pass;
      $result['user']['id'] = $id;

      Output::response($result);
    }
  }
?>
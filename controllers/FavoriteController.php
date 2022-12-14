<?php
class FavoriteController {
  static function add() {
    Router::allowed_method('POST');
    $data = Input::get_data();

    if (isset($data['type']) && $data['type'] != '') {
      $type = $data['type'] . 's';
    } else {
      $result['error']['message'] = 'Type parameter is required!';
      Output::response($result, 406);
    }
    $id_user = $data['id_user'];
    $identifier = $data['identifier'];

    $favorite = new Favorite(null, $id_user, $identifier);
    $id = $favorite->add($type);

    if ($id) {
      $result['success']['message'] = "Added row into favorite $type list!";
      $result['favorite'] = $data;
      Output::response($result);
    } else {
      $result['error']['message'] = "Content $identifier couldn't be added into favorite $type list!";
      Output::response($result, 404);
    }
  }

  static function by_user() {
    Router::allowed_method('GET');

    if (isset($_GET['id-user']) && $_GET['id-user'] != '') {
      $id_user = $_GET['id-user'];

      if (isset($_GET['type']) && $_GET['type'] != '') {
        $type = $_GET['type'] . 's';  
      } else {
        $result['error']['message'] = 'type parameter is required!';
        Output::response($result, 406);
      }
    } else {
      $result['error']['message'] = 'id-user parameter is required!';
      Output::response($result, 406);
    }

    $favorite = new Favorite(null, $id_user, null);
    $favorites_list = $favorite->get_by_id($type);

    if (is_array($favorites_list) && !empty($favorites_list)) {
      $result['success']['message'] = "User favorite $type selected!";
      $result['data'] = $favorites_list;
      Output::response($result);
    } else {
      $result['error']['message'] = "User favorite $type not found!";
      Output::response($result, 404);
    }
  }

  static function delete() {
    Router::allowed_method('DELETE');
    $data = Input::get_data();

    if (isset($data['type']) && $data['type'] != '') {
      $type = $data['type'] . 's';

      if (isset($data['id_user']) && $data['id_user'] != '') {
        $id_user = $data['id_user'];

        if (isset($data['identifier']) && $data['identifier'] != '') {
          $identifier = $data['identifier'];
        } else {
          $result['error']['message'] = 'identifier parameter is required!';
          Output::response($result, 406);
        }
      } else {
        $result['error']['message'] = 'id_user parameter is required!';
        Output::response($result, 406);
      }
    } else {
      $result['error']['message'] = 'type parameter is required!';
      Output::response($result, 406);
    }

    $favorite = new Favorite(null, $id_user, $identifier);
    $deleted = $favorite->delete($type);

    if ($deleted) {
      $result['success']['message'] = "Favorite $identifier deleted successfully from table $type!";
      Output::response($result);
    } else {
      $result['error']['message'] = "Favorite $identifier not found for deletion at table $type!";
      Output::response($result, 404);
    }
  }
}
?>
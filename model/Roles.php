<?php

include_once "../db/DBHandler.php";

class Roles {
  public static $ADMIN = "admin";
  public static $CREATOR = "creator";
  public static $CONTRIBUTOR = "contributor";

  public static function getUserList($roles) {
    $dbHandler = DBHandler::getInstance();

    $statement = "SELECT * FROM fundit_user WHERE roles={$roles}";
    $result = $dbHandler->execute($statement, true);

    $users = array();
    foreach ($result as $res) {
      $users[] = new User($res['id'], $res['name'], $res['roles'], $res['email'], $res['password']);
    }

    return $users;
  }

}

?>

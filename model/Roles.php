<?php

include_once __DIR__ . '/../db/DBHandler.php';

class Roles {
  public static $ADMIN = "admin";
  public static $CREATOR = "creator";
  public static $CONTRIBUTOR = "contributor";

  public static function getUserList($roles) {
    $statement = "SELECT * FROM fundit_user WHERE roles='{$roles}'";
    $result = DBHandler::execute($statement, true);

    $users = array();
    foreach ($result as $res) {
      $users[] = new User($res['USERNAME'], $res['NAME'], $res['ROLES'], $res['EMAIL'], $res['PASSWORD']);
    }

    return $users;
  }

}

?>

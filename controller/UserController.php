<?php
include_once __DIR__ . '/../model/User.php';

namespace UserController {

function signIn($username, $password) {
  $user = getUser($username);

  if (isset($user) && $user->verifyPassword($password)) {
    $_SESSION["username"] = $user->getUsername();
    return true;
  } else {
    return false;
  }
}

function signOut() {
  unset($_SESSION["username"]);
}

function isSignedIn() {
  if($_SESSION["username"]) {
    return true;
  } else {
    return false;
  }
}

function getSignedInUser() {
  if (!isset($_SESSION['username'])) {
    return null;
  } else {
    return getUser($_SESSION['username']);
  }
}

function createNewUser($username, $name, $roles, $email, $password) {
  $password = md5($password);

  $statement = "INSERT INTO fundit_user (username, name, roles, email, password) VALUES ('{$username}', '{$name}', '{$roles}', '{$email}', '{$password}')";
  $r = DBHandler::execute($statement, false);

  if ($r) {
    return new User($username, $name, $roles, $email, $password);
  } else {
    return null;
  }
}

function getUser($username) {
  $statement = "SELECT * FROM fundit_user WHERE username = '{$username}'";
  $result = DBHandler::execute($statement, true);

  if (count($result) != 1) {
    return null;
  } else {
    $result = $result[0];
    return new User($result['USERNAME'], $result['NAME'], $result['ROLES'],
      $result['EMAIL'], $result['PASSWORD']);
  }
}

}

?>

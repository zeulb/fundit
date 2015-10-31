<?php
namespace UserController {

include_once __DIR__ . '/../db/DBHandler.php';
include_once __DIR__ . '/../model/User.php';

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
  $r = \DBHandler::execute($statement, false);

  if ($r) {
    return new \User($username, $name, $roles, $email, $password);
  } else {
    return null;
  }
}

function getUser($username) {
  $statement = "SELECT * FROM fundit_user WHERE username = '{$username}'";
  $result = \DBHandler::execute($statement, true);

  if (count($result) != 1) {
    return null;
  } else {
    $result = $result[0];
    return new \User($result['USERNAME'], $result['NAME'], $result['ROLES'],
      $result['EMAIL'], $result['PASSWORD']);
  }
}

function isCreator($username) {
  if (isset($username)) {
    $statement = "SELECT roles FROM fundit_user WHERE username = '{$username}'";
    $result = \DBHandler::execute($statement, true);

    if (count($result) != 1) {
      return false;
    } else {
      return $result[0]['ROLES'] == 'creator' || $result[0]['ROLES'] == 'admin';
    }
  } else {
    return false;
  }
}

function isContributor($username) {
  if (isset($username)) {
    $statement = "SELECT * FROM fundit_user WHERE username = '{$username}'";
    $result = \DBHandler::execute($statement, true);

    return count($result) == 1;
  } else {
    return false;
  }
}

function isAdmin($username) {
  if (isset($username)) {
    $statement = "SELECT * FROM fundit_user WHERE username = '{$username}'";
    $result = \DBHandler::execute($statement, true);

    return count($result) == 1 && $result[0]['ROLES'] == 'admin';
  } else {
    return false;
  }
}

function getAllUser() {
  $executingUser = isset($_SESSION['username']) ? getUser($_SESSION['username']) : null;
  if ($executingUser == null || $executingUser->getRoles() != 'admin') {
    return null;
  }

  $statement = "SELECT * FROM fundit_user";
  $result = DBHandler::execute($statement, true);

  $userList = array();
  foreach ($result as $res) {
    $userList[] = new \User($res['username'], $res['name'], $res['roles'], $res['email'], $res['password']);
  }

  return $userList;
}

}

?>

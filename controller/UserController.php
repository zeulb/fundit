<?php
include_once __DIR__ . '/../model/User.php';

function signIn($username, $password) {
  $user = User::getUser($username);

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

?>
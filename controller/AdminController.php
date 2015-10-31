<?php

namespace AdminController {

function isAdminLoggedIn() {
  if (!isset($_SESSION['username'])) {
    return false;
  }
  $username = $_SESSION['username'];
  $user = \UserController\getUser($username);

  return $user->getRoles() == 'admin';
}

}

?>

<?php
  session_start();
  $current_page = 'Sign Out';
  include_once "controller/UserController.php";
  UserController\signOut();
  header("Location: index.php");
?>

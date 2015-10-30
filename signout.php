<?php
  session_start();
  include_once "controller/UserController.php";
  signOut();
  header("Location: index.php");
?>

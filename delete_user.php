<?php
  session_start();
  $current_page = 'Users';
  include_once "controller/UserController.php";

  if (isset($_GET['name'])) {
    $userName = $_GET['name'];
    $user = UserController\getUser($userName);
  }

  if (!isset($user)) {
    header("Location: index.php");
  }

  UserController\removeUser($userName);
  $message = "User deleted";
  $message_type = "success";
?>

<?php ob_start(); ?>
  <div class="inner cover container">
    <div class="row">
      <?php
        include_once 'template/message.php';
      ?>
    </div>
  </div>
<?php
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

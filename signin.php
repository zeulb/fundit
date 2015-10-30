<?php
  session_start();
  $current_page = 'Sign In';

  if (isset($_SESSION["username"])) {
    header("Location: index.php");
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST["username"];
    $password = $_POST["password"];

    include_once 'controller/UserController.php';
    if (signIn($username, $password)) {
      header("Location: index.php");
    } else {
      $message = "Wrong username or password";
      $message_type = "danger";
    }
  }

?>

<? ob_start(); ?>
  <br/>
  <div class="inner cover container">
    <div class="row">

      <?php
        include_once 'template/message.php';
      ?>
      
      <form method="post" class="form" role="form">
        <div class="form-group ">
          <label class="control-label" for="username">Username</label>
          <input class="form-control" id="username" name="username" required type="text" value="">
        </div>
        <div class="form-group ">
          <label class="control-label" for="password">Password</label>
          <input class="form-control" id="password" name="password" required type="password" value="">
        </div>
        <button class="btn btn-success" id="submit" name="submit" type="buttom">Submit</button>
      </form>
      <br/>
    </div>
  </div>
<? 
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

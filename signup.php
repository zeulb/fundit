<?php
  session_start();
  $current_page = 'Sign Up';

  if (isset($_SESSION["username"])) {
    header("Location: index.php");
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once("controller/UserController.php");
    $fullname = $_POST["fullname"];
    $roles = $_POST["roles"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $verify_password = $_POST["verify_password"];
    if ($password !== $verify_password) {
      $message = "Password doesn't match";
      $message_type = "danger";
    } else {
      $message = "User created";
      $message_type = "success";

      $user = UserController\createNewUser($username, $fullname,
        $roles, $email, $password);

      if (isset($user)) {
        unset($fullname);
        unset($roles);
        unset($username);
        unset($email);
      } else {
        $message = "Username or email already exists or invalid email format";
        $message_type = "danger";
      }
    }
  }
?>

<? ob_start(); ?>
  <br/>
  <div class="inner cover container">
    <div class="row">

      <?php
        include_once 'template/message.php'
      ?>
      <form method="post" class="form" role="form">
        <div class="form-group ">
          <label class="control-label" for="fullname">Full Name</label>
          <input class="form-control" id="fullname" name="fullname" required type="text" value="<?php echo $fullname ?>">
        </div>
        <div class="form-group">
          <label for="roles">Roles</label>
          <select class="form-control" id="roles" name="roles" selected="<?php echo $roles ?>">
            <option <?php echo $roles == 'creator' ? "selected" : ""; ?> value="creator">Creator</option>
            <option <?php echo $roles == 'contributor' ? "selected" : ""; ?> value="contributor">Contributor</option>
          </select>
        </div>
        <div class="form-group ">
          <label class="control-label" for="username">Username</label>
          <input class="form-control" id="username" name="username" required type="text" value="<?php echo $username ?>">
        </div>
        <div class="form-group ">
          <label class="control-label" for="email">Email</label>
          <input class="form-control" id="email" name="email" required type="text" value="<?php echo $email ?>">
        </div>
        <div class="form-group ">
          <label class="control-label" for="password">Password</label>
          <input class="form-control" id="password" name="password" required type="password" value="">
        </div>
        <div class="form-group ">
          <label class="control-label" for="verify_password">Verify Password</label>
          <input class="form-control" id="verify_password" name="verify_password" required type="password" value="">
        </div>
        <button class="btn btn-success" id="submit" name="submit" type="buttom">Submit</button>
      </form>
      <br/>
    </div>
    
  </div>
<?php
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

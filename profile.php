<?php
  session_start();
  $current_page = 'Profile';
  include_once "controller/UserController.php";

  $username = $_SESSION["username"];

  if (isset($_GET["name"])) {
    $username = $_GET["name"];
  }

  if (!UserController\canActiveUserModifyUser($username)) {
    $message = "Permission denied";
    $message_type = "danger";
  } else {
    $user = UserController\getUser($username);
    $fullname = $user->getName();
    $email = $user->getEmail();
    $roles = $user->getRoles();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      include_once("controller/UserController.php");
      $fullname = $_POST["fullname"];
      $email = $_POST["email"];
      $password = $_POST["password"];
      $verify_password = $_POST["verify_password"];
      $roles = $_POST["roles"];

      if ($password !== $verify_password) {
        $message = "Password doesn't match";
        $message_type = "danger";
      } else {
        $message = "Profile updated";
        $message_type = "success";

        $user = UserController\getSignedInUser();

        if ($user->setEmail($email)) {
          $message = "Invalid email or email already exists";
          $message_type = "danger";
        } else {
          $user->setPassword($password);
          $user->setName($fullname);
          if (UserController\isAdmin($_SESSION["username"])) {
            $user->setRoles($roles);
          }
        }   
      }
    }
  }
?>

<?php ob_start(); ?>
  <br/>
  <div class="inner cover container">
    <div class="row">

      <?php
        include_once 'template/message.php';
        if ($message_type != 'danger') {
      ?>
      <div class="row">
        
        <h1 class="page-header text-left">Edit Profile 
        <a href="user.php?name=<?php echo $user->getUsername(); ?>">
        <small><?php echo $user->getUsername() ?></small>
        </a>
        </h1>
      </div>
      <form method="post" class="form" role="form">
        <div class="form-group ">
          <label class="control-label" for="fullname">Full Name</label>
          <input class="form-control" id="fullname" name="fullname" required type="text" value="<?php echo $fullname ?>">
        </div>
        <div class="form-group ">
          <label class="control-label" for="email">Email</label>
          <input class="form-control" id="email" name="email" required type="text" value="<?php echo $email ?>">
        </div>
        <?php
        if (UserController\isAdmin($_SESSION["username"])) {
            ?>
              <div class="form-group">
          <label for="roles">Roles</label>
          <select class="form-control" id="roles" name="roles">
            <option <?php echo $user->getRoles() == 'admin' ? "selected" : ""; ?> value="admin">Administrator</option>
            <option <?php echo $user->getRoles() == 'creator' ? "selected" : ""; ?> value="creator">Creator</option>
            <option <?php echo $user->getRoles() == 'contributor' ? "selected" : ""; ?> value="contributor">Contributor</option>
          </select>
        </div>
            <?php
          }
        ?>
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
  }
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

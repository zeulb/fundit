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

        $user = UserController\getUser($username);

        if ($user->setEmail($email)) {
          $message = "Invalid email or email already exists";
          $message_type = "danger";
        } else {
          if (strlen($password) > 0) {
            $user->setPassword($password);
          }
          $user->setName($fullname);
          if (UserController\isAdmin($_SESSION["username"])) {
            $user->setRoles($roles);
          }
        }
      }
    }
  } 

  if (!isset($user)) {
    $message = "No such username";
    $message_type = "danger";
  }
?>

<?php ob_start(); ?>
  <br/>
  <div class="inner cover container">
    <?php
        include_once 'template/message.php';
        if ($message_type != 'danger') {
          echo $message;
          echo $message_type;
      ?>

    <div class="row"> 
      <ul class="nav nav-pills">
        <li role="presentation"><a href="user.php?name=<?php echo $user->getUsername(); ?>"><?php echo $user->getUsername(); ?></a></li>
        <li role="presentation"><a href="user.php?page=project&name=<?php echo $user->getUsername(); ?>">Project started</a></li>
        <li role="presentation"><a href="user.php?page=contribution&name=<?php echo $user->getUsername(); ?>">Contributions</a></li>

        <?php
          if (UserController\canActiveUserModifyUser($username)) {
        ?>
        <li role="presentation" class="active" style="float:right;"><a href="profile.php?name=<?php echo $user->getUsername(); ?>">Edit Profile</a></li>
        <?php
          }
        ?>
      </ul>
    </div>

    <div class="row">
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
          <input class="form-control" id="password" name="password" type="password" value="">
        </div>
        <div class="form-group ">
          <label class="control-label" for="verify_password">Verify Password</label>
          <input class="form-control" id="verify_password" name="verify_password" type="password" value="">
        </div>
        <button class="btn btn-success" id="submit" name="submit" type="buttom">Submit</button>
      <a href="delete_user.php?name=<?php echo $user->getUsername() ?>">
          <button class="btn btn-danger" type="button">Delete</button>
        </a>
      </form>
      <br/>
    </div>
    
  </div>
<?php
  }
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

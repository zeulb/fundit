<?php
  function isActive($page) {
    global $current_page;
    if ($page == $current_page) {
      return "active";
    } else {
      return "";
    }
  }
  include_once("controller/UserController.php");
?>

<div class="masthead clearfix">
  <div class="inner">
    <h3 class="masthead-brand">FundIt</h3>
    <nav>
      <ul class="nav masthead-nav">
        <li class="<?php echo isActive('Home'); ?>"><a href="index.php">Home</a></li>
        <li class="<?php echo isActive('Projects'); ?>"><a href="project.php">Projects</a></li>
        <?php
          if (UserController\isAdmin($_SESSION["username"])) {
            ?>
        <li class="<?php echo isActive('Users'); ?>"><a href="user_list.php">Users</a></li>
        <li class="<?php echo isActive('Contributions'); ?>"><a href="contribution.php">Contributions</a></li>
        <?php
          }
            ?>

        <?php
          if (isset($_SESSION["username"])) {
            ?>
            <li class="<?php echo isActive('Profile'); ?>"><a href="profile.php">Hi, <?php echo $_SESSION["username"]; ?></a></li>
            <li class="<?php echo isActive('Sign Out'); ?>"><a href="signout.php">Sign Out</a></li>
            <?php
          } else {
            ?>
            <li class="<?php echo isActive('Sign In'); ?>"><a href="signin.php">Sign In</a></li>
            <li class="<?php echo isActive('Sign Up'); ?>"><a href="signup.php">Sign Up</a></li>
            <?php
          }
        ?>
      </ul>
    </nav>
  </div>
</div>
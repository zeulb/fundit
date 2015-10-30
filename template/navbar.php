<?php
  function isActive($page) {
    global $current_page;
    if ($page == $current_page) {
      return "active";
    } else {
      return "";
    }
  }
?>

<div class="masthead clearfix">
  <div class="inner">
    <h3 class="masthead-brand">FundIt</h3>
    <nav>
      <ul class="nav masthead-nav">
        <li class="<?php echo isActive('Home'); ?>"><a href="index.php">Home</a></li>
        <li class="<?php echo isActive('Projects'); ?>"><a href="project.php">Projects</a></li>
        <li class="<?php echo isActive('Contributors'); ?>"><a href="user.php">Contributors</a></li>
        <?php
          if (isset($_SESSION["username"])) {
            ?>
            <li class="<?php echo isActive('Profile'); ?>"><a href="profile.php">Welcome, <?php echo $_SESSION["username"]; ?></a></li>
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
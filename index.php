<?php
  session_start();
  $current_page = 'Home';
?>

<?php ob_start(); ?>
  <link href="css/vertical.css" rel="stylesheet">
  <div class="inner cover">
    <h1 class="cover-heading">Welcome to FundIt</h1>
    <p class="lead">Crowdfunding site</p>
    <p class="lead">
      <a href="#" class="btn btn-lg btn-default">Learn more</a>
    </p>
  </div>
<?php
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

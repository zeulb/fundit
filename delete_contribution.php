<?php
  session_start();
  $current_page = 'Projects';
  include_once "controller/ContributionController.php";

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $contribution = ContributionController\getContribution($id);
  }
  if (!isset($contribution)) {
    header("Location: index.php");
  }

  ContributionController\removeContribution($id);
  $message = "Contribution deleted";
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

<?php
  session_start();
  $current_page = 'Projects';
  include_once "controller/ProjectController.php";

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $project = ProjectController\getProject($id);
  }
  if (!isset($project)) {
    header("Location: index.php");
  }

  ProjectController\removeProject($id);
  $message = "Project deleted";
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

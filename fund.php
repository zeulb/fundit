<?php
  session_start();
  $current_page = 'Projects';
  include_once "controller/ProjectController.php";
  include_once "controller/ContributionController.php";
  include_once "controller/UserController.php";

  $fund = "";

  if (!UserController\isSignedIn() || !UserController\isContributor($_SESSION["username"])) {
    $message = "Login to fund this project!";
    $message_type = "danger";
  } else if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $project = ProjectController\getProject($id);
    if (!isset($project)) {
      $message = "Project with id ".$id." not found";
      $message_type = "danger";
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fund = $_POST["fund"];

    $contribution = ContributionController\createNewContribution($project->getId(), $fund);
    if (!isset($contribution)) {
      $message = "Please enter fund in number";
      $message_type = "danger";
    } else {
      $message = "Thanks for funding ".$project->getTitle();
      $message_type = "success";
    }
  }
?>

<?php ob_start(); ?>
  <br/>
  <div class="inner cover container">
    <div class="row">

      <?php
        include_once 'template/message.php';
      ?>

      <?php
        if (isset($project)) { ?>
      
      <form method="post" class="form" role="form">
        <h1 class="page-header text-left"><?php echo $project->getTitle(); ?> </h1>
        <div class="form-group ">
          <label class="control-label" for="fund">Fund</label>
          <div class='input-group date' id='fund' >
              <span class="input-group-addon">
                  <span class="glyphicon glyphicon-usd"></span>
              </span>
              <input type='text' class="form-control" name="fund" />
          </div>
        </div>
        <button class="btn btn-success" id="submit" name="submit" type="buttom">Submit</button>
      </form>
      <br/>
      <?php
        }
      ?>
    </div>
  </div>
<?php
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

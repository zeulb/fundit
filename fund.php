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
    } else if (!$project->isProjectOpen()) {
      $message = "Project funding is over";
      $message_type = "danger";
    }
  }

  if (isset($project) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $fund = $_POST["fund"];
    $comment = $_POST["message"];
    $contribution = ContributionController\createNewContribution($project->getId(), $fund, $comment);
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
    <?php
      include_once 'template/message.php';
      if ($message_type != 'danger') {
    ?>
    <div class="row"> 
        <ul class="nav nav-pills">
          <li role="presentation" class="active"><a href="project.php?id=<?php echo $project->getId(); ?>"><?php echo $project->getTitle(); ?></a></li>
          <li role="presentation"><a href="project.php">Recent</a></li>
          <li role="presentation"><a href="#">Popular</a></li>

          <?php
            if (UserController\isSignedIn() && UserController\isCreator($_SESSION["username"])) {
          ?>
          <li role="presentation" style="float:right;"><a href="new_project.php">Create Project</a></li>
          <li role="presentation" style="float:right;"><a href="#">Managed Project</a></li>
          <?php
            }
          ?>
        </ul>
      </div>
    <div class="row">
      
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
        <div class="form-group ">
          <label class="control-label" for="message">Message</label>
          <textarea class="form-control" rows="3" id="message" name="message"></textarea>
        </div>
        <button class="btn btn-success" id="submit" name="submit" type="buttom">Submit</button>
      </form>
      <br/>
      
    </div>
    <?php
        }
      ?>
  </div>
<?php
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

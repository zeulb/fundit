<?php
  session_start();
  $current_page = 'Projects';
  include_once "controller/UserController.php";
  include_once "controller/ProjectController.php";

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $project = ProjectController\getProject($id);
    if (!isset($project)) {
      $message = "Project with id ".$id." not found";
      $message_type = "danger";
    }
  }
?>

<?php ob_start(); ?>
  <br/>
  <?php if (!isset($project)) { ?>
  <div class="inner cover container">
    <div class="row">
      <?php
        include_once 'template/message.php';
      ?>
      <h4 class = "text-left">Recent</h4>
      <?php
      if (UserController\isSignedIn()) {
        ?>
        <h4 class = "text-right">
          <a href="newproject.php">
            <button type="button" class="btn btn-warning">New Project</button>
          </a>
        </h4>
      <?php
        }
      ?>
    </div>
    <?php
    $projectList = ProjectController\getAllProject();
    foreach($projectList as $project) {?>
    <div class="row">
      <hr/>
      <div class="col-md-6">
        <h4 class = "text-left"> <?php echo $project->getTitle(); ?> </h4>
        <p class = "text-left">
        by <a href="user.php?name=<?php echo $project->getOwner(); ?>">
        <?php
        $username = $project->getOwner();
        echo UserController\getUser($username)->getName(); ?>
        </a>
        ·
        <?php echo $project->getContributorCount(); ?> funders
        </p>
      </div>
      <div class="col-md-6" align="right">
        <h4 class = "text-right"> $<?php echo $project->getTotalContribution(); ?> </h4>
        <a href="project.php?id=<?php echo $project->getId() ?>">
          <button type="button" class="btn btn-success">Fund!</button>
        </a>
      </div>
    </div>
    <?php
    }} else { ?>
      
      <div class="inner cover container">
        <div class="row">
          <h1 class="page-header text-left"><?php echo $project->getTitle(); ?>
          <small> by <a href="user.php?name=<?php echo $project->getOwner(); ?>">
            <?php
            $username = $project->getOwner();
            echo UserController\getUser($username)->getName(); ?>
            </a>
          </small></h1>
        </div>
        <div class="row">
          <div class="progress">
            <?php
                $contribution = $project->getTotalContribution();
                $goal = $project->getGoal();
                $actualProgress = intval($contribution/$goal);
                $progress = min($actualProgress, 100);
            ?>

            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress; ?>%;">
              <?php echo $actualProgress; ?>
            </div>
          </div>
        </div>
        <div class="row">
          <p class="text-left"><?php echo $project->getDescription(); ?></p>
        </div>
        <div class="row">
          <table class="table borderless" style="width:60%">
          <tbody>
            <tr>
              <td class="text-left">Total Fund</td>
              <td class="text-left">:</td>
              <td class="text-left"><?php echo $project->getTotalContribution(); ?></td>
            </tr>
            <tr>
              <td class="text-left">Total Funders</td>
              <td class="text-left">:</td>
              <td class="text-left"><?php echo $project->getContributorCount(); ?></td>
            </tr>
          </tbody>
          </table>
        </div>
      </div>


    <?php } ?>

    
    <div class="row">
      <hr/>
    </div>
  </div>
<?php
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

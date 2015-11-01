<?php
  session_start();
  $current_page = 'Projects';
  include_once "controller/UserController.php";
  include_once "controller/ProjectController.php";

  $default_page = "recent";

  $page = $default_page;

  if (isset($_GET['page'])) {
    $page = $_GET['page'];
  }

  if ($page != 'recent' && $page != 'popular' && $page != 'manager') {
    $page = $default_page;
  }

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
      <div class="row"> 
        <ul class="nav nav-pills">
          <li role="presentation" class="<?php echo $page == 'recent' ? "active" : "" ?>"><a href="project.php">Recent</a></li>
          <li role="presentation" class="<?php echo $page == 'popular' ? "active" : "" ?>"><a href="project.php?page=popular">Popular</a></li>
          
          <?php
            if (UserController\isSignedIn() && UserController\isCreator($_SESSION["username"])) {
          ?>
          <li role="presentation" style="float:right;"><a href="new_project.php">Create Project</a></li>
          <li role="presentation" class="<?php echo $page == 'manager' ? "active" : "" ?>" style="float:right;"><a href="project.php?page=manager">Managed Project</a></li>
          <?php
            }
          ?>
        </ul>
      </div>
    </div>
    <?php
    echo $page;
    if ($page == "recent") {
      $projectList = ProjectController\getAllProject();
    } else if ($page == "popular") {
      $projectList = ProjectController\getAllProjectPopular();
    } else if ($page == "manager") {
      $projectList = ProjectController\getActiveUserProject();
    }
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
        <?php echo $project->getContributorCount(); ?> funder(s)
        </p>
      </div>
      <div class="col-md-6" align="right">
        <h4 class = "text-right"> $<?php echo $project->getTotalContribution(); ?> </h4>
        <?php
          if (UserController\canActiveUserModifyProject($project->getId())) {
            ?>
            <a href="edit_project.php?id=<?php echo $project->getId() ?>">
              <button type="button" class="btn btn-info">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </button>
            </a>
            <?php
          } 

        ?>
        <a href="project.php?id=<?php echo $project->getId() ?>">
          <button type="button" class="btn btn-warning">Fund!</button>
        </a>
        
         
      </div>
      

    </div>
    <?php
    }} else { ?>

    <?php
    $contributionList = $project->getContributionList();
  ?>
      <div class="inner cover container">
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
                $actualProgress = (100.0*$contribution/$goal);
                $progress = min($actualProgress, 100);
                if ($progress > 8.0) {
                  $progressString = number_format($actualProgress, 2, '.', '')."%";
                } else {
                  $progressString = "";
                }
            ?>

            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress; ?>%;">
              <p class="text-middle">
                <?php echo $progressString; ?>
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <p class="lead text-left"><?php echo $project->getDescription(); ?></p>
            
          </div>
          <div class="col-md-4">
            <h3 class="text-right">
            <?php
            if (UserController\canActiveUserModifyProject($project->getId())) {
              ?>
              <a href="edit_project.php?id=<?php echo $project->getId() ?>">
                <button type="button" class="btn btn-info">
                  <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Manage
                </button>
              </a>
              <?php
            } 

          ?>
              <a href="fund.php?id=<?php echo $project->getId() ?>">
                <button type="button" class="btn btn-warning">Fund!</button>
              </a>
            </h3>
            <h3 class = "text-left">
              <?php echo $project->getContributorCount() ?>
            </h3>
            <p class="lead text-left">
              <?php echo " funder(s)"; ?>
            </p>
            <h3 class = "text-left">
              <?php echo "$".$project->getTotalContribution() ?>
            </h3>
            <p class="lead text-left">
              <?php echo "collected of $".$project->getGoal()." goal"; ?>
            </p>
            <h4 class = "text-left">
              <?php echo $project->getDeadline(); ?>
            </h4>
          </div>
        </div>
        <div class="row">
          
        </div>
        <div class="row">
        <h3 class="text-left"> Comments </h3>
          
        </div>
        
        <?php foreach ($contributionList as $contribution) {
            $contributorUsername = $contribution->getContributor();
            $contributor = UserController\getUser($contributorUsername);
        ?>
        <div class="row">
          <div class="col-md-10">
          <h4 class="text-left"><?php echo $contributor->getName()." on ". $contribution->getDate() ?></h4>
          <p class="text-left"><?php echo $contribution->getComment() ?></p>
          <p class="text-left"><?php echo "Contribution: $".$contribution->getAmount(); ?>
          </p>
          </div>
          <div class="col-md-2">
          <p class="text-right">
          <?php if (UserController\canActiveUserModifyContribution($contribution->getId())) {?>
              <a href="edit_contribution.php?id=<?php echo $contribution->getId() ?>">
              <button type="button" class="btn btn-info btn-sm">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </button>
            </a>
              <?php
              } ?>
            </p>
          </div>
        </div>
        <hr>
        <?php } ?>

      </div>
      

    <?php } ?>
  </div>
<?php
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

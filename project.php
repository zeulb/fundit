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
      if (UserController\isSignedIn() && UserController\isCreator($_SESSION["username"])) {
        ?>
        <h4 class = "text-right">
          <a href="new_project.php">
            <button type="button" class="btn btn-info">New Project</button>
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
        <?php echo $project->getContributorCount(); ?> funder(s)
        </p>
      </div>
      <div class="col-md-6" align="right">
        <h4 class = "text-right"> $<?php echo $project->getTotalContribution(); ?> </h4>
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
          <h3 class="text-right">
            <a href="fund.php?id=<?php echo $project->getId() ?>">
              <button type="button" class="btn btn-warning">Fund!</button>
            </a>
          </h3>
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
        <div class="row">
        <h3 class="text-left"> Contribution </h3>
        <table class="table text-left table-hover">
        <thead>
          <tr>
            <th> # </th>
            <th> Timestamp </th>
            <th> Contributor </th>
            <th> Amount </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($contributionList as $contribution) {
            $counter++;
            $contributorUsername = $contribution->getContributor();
            $contributor = UserController\getUser($contributorUsername);
          ?>
          <tr>
            <td>
              <?php echo $counter; ?>
            </td>
            <td>
              <?php echo $contribution->getDate(); ?>
            </td>
            <td>
              <a href="user.php?name=<?php echo $contributor->getUsername(); ?>">
              <?php 
                echo $contributor->getName();
              ?>
              </a>
            </td>
            <td>
            $<?php echo $contribution->getAmount(); ?>
            </td>
          </tr>
          <?php }
          ?>
        </tbody>
        </table>
        </div>
      </div>
      

    <?php } ?>
  </div>
<?php
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

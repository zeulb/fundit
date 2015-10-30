<?php
  session_start();
  $current_page = 'Project';
  include_once "controller/UserController.php";
  include_once "controller/ProjectController.php";
?>

<?php ob_start(); ?>
  <br/>
  <div class="inner cover container">
    <div class="row">
      <h4 class = "text-left">Recent</h4>
    </div>
    <?php
    $projectList = ProjectController\getAllProject();
    foreach($projectList as $project) {?>
    <div class="row">
      <hr/>
      <div class="col-md-6">
        <h4 class = "text-left"> <?php echo $project->getTitle(); ?> </h4>
        <p class = "text-left">
        by <?php 
        $username = $project->getOwner();
        echo UserController\getUser($username)->getName() ?>
        ·
        <?php echo $project->getContributorCount(); ?> funders
        </p>
      </div>
      <div class="col-md-6" align="right">
        <h4 class = "text-right"> $<?php echo $project->getTotalContribution(); ?> </h4>
        <button type="button" class="btn btn-success">Fund!</button>
      </div>
    </div>
    <?php
    }?>
    
    <div class="row">
      <hr/>
    </div>
  </div>
<?php
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

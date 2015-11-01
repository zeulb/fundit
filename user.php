<?php
  session_start();
  $current_page = 'Contributors';
  include_once "controller/UserController.php";
  include_once "controller/ProjectController.php";
  include_once "controller/ContributionController.php";

  $username = $_SESSION["username"];

  if (isset($_GET["name"])) {
    $username = $_GET["name"];
  }

  $page = "profile";

  if (isset($_GET["page"])) {
    $page = $_GET["page"];
  }

  if ($page != "profile" && $page != "project" && $page != "contribution") {
    $page = "profile";
  }
  
  $user = UserController\getUser($username);

  if (!isset($user)) {
    header("Location: index.php");
    $message = "No such user";
    $message_type = "danger";
  }

  $contributionList = $user->getContributionList();
  $projectList = $user->getProjectList();
  $counterContribution = 0;
  $counterProject = 0;
?>

<?php ob_start(); ?>
  <?php
    if ($page == 'profile') {
  ?>
  <br/>
  <div class="inner cover container">

    <div class="row"> 
      <ul class="nav nav-pills">
        <li role="presentation" class="active"><a href="user.php?name=<?php echo $user->getUsername(); ?>"><?php echo $user->getUsername(); ?></a></li>
        <li role="presentation"><a href="user.php?page=project&name=<?php echo $user->getUsername(); ?>">Project started</a></li>
        <li role="presentation"><a href="user.php?page=contribution&name=<?php echo $user->getUsername(); ?>">Contributions</a></li>

        <?php
          if (UserController\canActiveUserModifyUser($username)) {
        ?>
        <li role="presentation" style="float:right;"><a href="profile.php?name=<?php echo $user->getUsername(); ?>">Edit Profile</a></li>
        <?php
          }
        ?>
      </ul>
    </div>

    <div class="row">
      <h1 class="page-header text-left"><?php echo $user->getUsername(); ?></h1>
    </div>
    <div class="row">
      <table class="table borderless text-left" style="width:60%">
        <tbody>
          <tr>
            <td class="lead" >Name:</td>
            <td class="lead" ><?php echo $user->getName(); ?></td>
          </tr>
          <tr>
            <td class="lead" >Email:</td>
            <td class="lead" ><?php echo $user->getEmail(); ?></td>
          </tr>
          <tr>
            <td class="lead" >Role:</td>
            <td class="lead" ><?php echo $user->getRoles(); ?></td>
          </tr>
          <tr>
            <td class="lead" >Contribution:</td>
            <td class="lead" ><?php echo "$".$user->getTotalContribution(); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <?php } else if ($page == "project") {?>
  <br/>
  <div class="inner cover container">

    <div class="row"> 
      <ul class="nav nav-pills">
        <li role="presentation"><a href="user.php?name=<?php echo $user->getUsername(); ?>"><?php echo $user->getUsername(); ?></a></li>
        <li role="presentation" class="active"><a href="user.php?page=project&name=<?php echo $user->getUsername(); ?>">Project started</a></li>
        <li role="presentation"><a href="user.php?page=contribution&name=<?php echo $user->getUsername(); ?>">Contributions</a></li>

        <?php
          if (UserController\canActiveUserModifyUser($username)) {
        ?>
        <li role="presentation" style="float:right;"><a href="profile.php?name=<?php echo $user->getUsername(); ?>">Edit Profile</a></li>
        <?php
          }
        ?>
      </ul>
    </div>
      <table class="table text-left table-hover">
      <thead>
        <tr>
          <th> # </th>
          <th> Project </th>
          <th> Progress </th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($projectList as $project) {
          $counterProject++;
        ?>
        <tr>
          <td>
            <?php echo $counterProject; ?>
          </td>
          <td>
            <a href="project.php?id=<?php echo $project->getId(); ?>">
            <?php echo $project->getTitle(); ?>
            </a>
          </td>
          <td>
            <?php 
              echo "$".$project->getTotalContribution();
            ?>
            /
            <?php 
              echo "$".$project->getGoal();
            ?>
          </td>
        </tr>
        <?php }
        ?>
      </tbody>
      </table>
      
    </div>
  </div>
  <?php } else if ($page == 'contribution') {?>
  <br/>
  <div class="inner cover container">

    <div class="row"> 
      <ul class="nav nav-pills">
        <li role="presentation"><a href="user.php?name=<?php echo $user->getUsername(); ?>"><?php echo $user->getUsername(); ?></a></li>
        <li role="presentation"><a href="user.php?page=project&name=<?php echo $user->getUsername(); ?>">Project started</a></li>
        <li role="presentation" class="active"><a href="user.php?page=contribution&name=<?php echo $user->getUsername(); ?>">Contributions</a></li>

        <?php
          if (UserController\canActiveUserModifyUser($username)) {
        ?>
        <li role="presentation" style="float:right;"><a href="profile.php?name=<?php echo $user->getUsername(); ?>">Edit Profile</a></li>
        <?php
          }
        ?>
      </ul>
    </div>
      <table class="table text-left table-hover">
      <thead>
        <tr>
          <th> # </th>
          <th> Timestamp </th>
          <th> Project </th>
          <th> Amount </th>
          <?php if (UserController\isAdmin($_SESSION["username"])) {
              echo "<th> Modify </th>";
              } ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($contributionList as $contribution) {
          $counterContribution++;
          $projectId = $contribution->getProjectId();
          $project = ProjectController\getProject($projectId);
        ?>
        <tr>
          <td>
            <?php echo $counterContribution; ?>
          </td>
          <td>
            <?php echo $contribution->getDate(); ?>
          </td>
          <td>
            <a href="project.php?id=<?php echo $project->getId(); ?>">
            <?php 
              echo $project->getTitle();
            ?>
            </a>
          </td>
          <td>
          $<?php echo $contribution->getAmount(); ?>
          </td>
          <?php if (UserController\canActiveUserModifyContribution($contribution->getId())) {?>
              <td>
              <a href="edit_contribution.php?id=<?php echo $contribution->getId() ?>">
              <button type="button" class="btn btn-info btn-xs">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </button>
            </a>
            </td>
              <?php
              } ?>
        </tr>
        <?php }
        ?>
      </tbody>
      </table>
    </div>
  </div>
  <?php } ?>

<?php
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

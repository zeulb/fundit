<?php
  session_start();
  $current_page = 'Contributors';
  include_once "controller/UserController.php";
  include_once "controller/ProjectController.php";
  include_once "controller/ContributionController.php";

  if (isset($_GET['name'])) {
    $username = $_GET['name'];
    $user = UserController\getUser($username);
  }
  
  if (!isset($user)) {
    header("Location: index.php");
  }

  $contributionList = $user->getContributionList();
  $counter = 0;
?>

<?php ob_start(); ?>
  <br/>
  <div class="inner cover container">
    <div class="row">
      <h1 class="page-header text-left"><?php echo $user->getUsername(); ?></h1>
    </div>
    <div class="row">
      <table class="table borderless text-left" style="width:60%">
        <tbody>
          <tr>
            <td >Name</td>
            <td >:</td>
            <td ><?php echo $user->getName(); ?></td>
          </tr>
          <tr>
            <td >Email</td>
            <td >:</td>
            <td ><?php echo $user->getEmail(); ?></td>
          </tr>
          <tr>
            <td >Roles</td>
            <td >:</td>
            <td ><?php echo $user->getRoles(); ?></td>
          </tr>
        </tbody>
      </table>
      <h3 class="text-left"> Contribution </h3>
      <table class="table text-left table-hover">
      <thead>
        <tr>
          <th> # </th>
          <th> Timestamp </th>
          <th> Project </th>
          <th> Amount </th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($contributionList as $contribution) {
          $counter++;
          $projectId = $contribution->getProjectId();
          $project = ProjectController\getProject($projectId);
        ?>
        <tr>
          <td>
            <?php echo $counter; ?>
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
        </tr>
        <?php }
        ?>
      </tbody>
      </table>
    </div>
  </div>
<?php
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

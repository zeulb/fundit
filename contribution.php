<?php
  session_start();
  $current_page = 'Contributions';
  include_once "controller/UserController.php";
  include_once "controller/ProjectController.php";
  include_once "controller/ContributionController.php";

  if (!UserController\isAdmin($_SESSION["username"])) {
    $message = "Permission denied";
    $message_type = "danger";
  }
?>

<?php ob_start(); ?>
  <br/>
  <div class="inner cover container">
    <div class="row">
      <?php
        include_once 'template/message.php';
        if ($message_type != 'danger') {
          $contributionList = ContributionController\getAllContribution();
          $counter = 0;
      ?>
      <div class="row">
        
        <h1 class="page-header text-left">Contribution List
        </h1>
      </div>

      <table class="table text-left table-hover">
      <thead>
        <tr>
          <th> # </th>
          <th> Id </th>
          <th> Contributor </th>
          <th> Project </th>
          <th> Timestamp </th>
          <th> Amount </th>
          <th> Manage </th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($contributionList as $contribution) {
          $contributorUsername = $contribution->getContributor();
          $projectId = $contribution->getProjectId();

          $contributor = UserController\getUser($contributorUsername);
          $project = ProjectController\getProject($projectId);
        ?>
        <tr>
          <td>
            <?php echo ++$counter; ?>
          </td>
          <td>
              <?php echo $contribution->getId(); ?>
          </td>
          <td>
            <a href="user.php?name=<?php echo $contributorUsername; ?>">
              <?php echo $contributor->getName(); ?>
            </a>
          </td>
          <td>
            <a href="project.php?id=<?php echo $projectId; ?>">
              <?php echo $project->getTitle(); ?>
            </a>
          </td>
          <td>
            <?php echo $contribution->getDate(); ?>
          </td>
          <td>
            <?php echo "$".$contribution->getAmount(); ?>
          </td>
          <td>
            <a href="edit_contribution.php?id=<?php echo $contribution->getId(); ?>">
              <button type="button" class="btn btn-info btn-xs">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </button>
            </a>
          </td>
        </tr>
        <?php }
        ?>
      </tbody>
      </table>
      <?php } ?>

      

    </div>

  </div>
<?php
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

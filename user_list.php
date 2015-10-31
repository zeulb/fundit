<?php
  session_start();
  $current_page = 'Users';
  include_once "controller/UserController.php";
  include_once "controller/ProjectController.php";

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
          $userList = UserController\getAllUser();
          $counter = 0;
      ?>

      <table class="table text-left table-hover">
      <thead>
        <tr>
          <th> # </th>
          <th> Username </th>
          <th> Name </th>
          <th> Roles </th>
          <th> Modify </th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($userList as $user) {
        ?>
        <tr>
          <td>
            <?php echo ++$counter; ?>
          </td>
          <td>
            <?php echo $user->getUsername(); ?>
          </td>
          <td>
            <?php echo $user->getName(); ?>
          </td>
          <td>
            <?php echo $user->getRoles(); ?>
          </td>
          <td>
            <a href="profile.php?name=<?php echo $user->getUsername() ?>">
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

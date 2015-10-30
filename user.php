<?php
  session_start();
  $current_page = 'Contributors';
  include_once "controller/UserController.php";

  if (isset($_GET['name'])) {
    $username = $_GET['name'];
    $user = UserController\getUser($username);
  }
  
  if (!isset($user)) {
    header("Location: index.php");
  }
?>

<?php ob_start(); ?>
  <br/>
  <div class="inner cover container">
    <div class="row">
      <h1 class="page-header text-left"><?php echo $user->getUsername(); ?></h1>
    </div>
    <div class="row">
      <table class="table borderless" style="width:60%">
        <tbody>
          <tr>
            <td class="text-left">Name</td>
            <td class="text-left">:</td>
            <td class="text-left"><?php echo $user->getName(); ?></td>
          </tr>
          <tr>
            <td class="text-left">Email</td>
            <td class="text-left">:</td>
            <td class="text-left"><?php echo $user->getEmail(); ?></td>
          </tr>
          <tr>
            <td class="text-left">Roles</td>
            <td class="text-left">:</td>
            <td class="text-left"><?php echo $user->getRoles(); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
<?php
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

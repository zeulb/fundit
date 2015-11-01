<?php
  session_start();
  date_default_timezone_set("Asia/Singapore");
  $current_page = 'Projects';
  include_once("controller/UserController.php");
  include_once("controller/ProjectController.php");
  include_once("controller/CategoryController.php");

  if (!UserController\isSignedIn() || !UserController\isCreator($_SESSION["username"])) {
    header("Location: index.php");
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST["category"];
    if (CategoryController\addCategory($category)) {
      $message = "New category added";
      $message_type = "success";
    } else {
      $message = "Category already exists";
      $message_type = "danger";
    }
  }
?>

<? ob_start(); ?>
  <br/>
  <div class="inner cover container">
    <div class="row">

      <?php
        include_once 'template/message.php'
      ?>

      <div class="row"> 
        <ul class="nav nav-pills">
          <li role="presentation"><a href="project.php">Recent</a></li>
          <li role="presentation"><a href="project.php?page=popular">Popular</a></li>
          <li role="presentation" class="active"><a href="project.php?page=category">Category</a></li>
          
          <?php
            if (UserController\isSignedIn() && UserController\isCreator($_SESSION["username"])) {
          ?>
          <li role="presentation" class="active" style="float:right;"><a href="new_project.php">Create Project</a></li>
          <li role="presentation" style="float:right;"><a href="project.php?page=manager">Managed Project</a></li>
          <?php
            }
          ?>
        </ul>
      </div>

      <form method="post" class="form" role="form">
        <div class="form-group ">
          <label class="control-label" for="category">New Category</label>
          <input class="form-control" id="category" name="category" required type="text" value="">
        </div>
        <button class="btn btn-success" id="submit" name="submit" type="buttom">Submit</button>
      </form>
      <br/>
    </div>
    
  </div>
<?php
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

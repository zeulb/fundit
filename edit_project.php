<?php
  session_start();
  $current_page = 'Projects';
  include_once("controller/UserController.php");
  include_once("controller/ProjectController.php");
  include_once("controller/CategoryController.php");

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $project = ProjectController\getProject($id);
  }

  if (isset($project)) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $title = $_POST["title"];
      $description = $_POST["description"];
      $goal = $_POST["goal"];
      $deadline = $_POST["deadline"];
      $selected = $_POST["category"];

      $project->setTitle($title);
      $project->setDescription($description);
      $project->setGoal($goal);
      $project->setDeadline($deadline);
      $project->setCategory($selected);

      $message = "Project updated";
      $message_type = "success";

    } else {
      $title = $project->getTitle();
      $description = $project->getDescription();
      $goal = $project->getGoal();
      $deadline = $project->getDeadline();
      $selected= $project->getCategory();
    }
  } else {
    $message = "Project with id ".$id." not found";
    $message_type = "danger";
  }

  if (isset($project) &&!UserController\canActiveUserModifyProject($project->getId())) {
    unset($project);
    $message = "Cannot edit selected project";
    $message_type = "danger";
  }

?>

<?php ob_start(); ?>
  <br/>
  <div class="inner cover container">
    <?php
        include_once 'template/message.php';
        if (isset($project)) {
      ?>
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

      
      <form method="post" class="form" role="form">
        <div class="form-group ">
          <label class="control-label" for="title">Title</label>
          <input class="form-control" id="title" name="title" type="text" required value="<?php echo $title; ?>">
        </div>
        <div class="form-group ">
          <label class="control-label" for="description">Description</label>
          <textarea class="form-control" rows="10" id="description" name="description"><?php echo $description; ?></textarea>
        </div>
        <div class="form-group">
          <label class="control-label" for="deadline">Deadline</label>
          <div class='input-group date' id='deadline' >
              <input type='text' class="form-control" name="deadline" value="<?php echo $deadline; ?>" />
              <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
              </span>
          </div>
        </div>
        <script type="text/javascript">
          $(function () {
            $('#deadline').datetimepicker({
              format: 'DD MMM YYYY hh:mm A'
            });
          });
        </script>
        
        <div class="form-group ">
          <label class="control-label" for="goal">Goal</label>
          <div class='input-group date' id='goal' >
              <span class="input-group-addon">
                  <span class="glyphicon glyphicon-usd"></span>
              </span>
              <input type='text' class="form-control" name="goal" value="<?php echo $goal; ?>"/>
          </div>
        </div>
        <div class="form-group">
          <label for="category">Category</label>
          <select class="form-control" id="category" name="category">
            <?php 
              $categoryList = CategoryController\getAllCategories();
              foreach($categoryList as $category) {
            ?>
            <option <?php echo $selected == $category->getCategory() ? "selected" : ""; ?> value="<?php echo $category->getCategory(); ?>"><?php echo $category->getCategory(); ?></option>
            <?php } ?>
          </select>
        </div>
        <button class="btn btn-success" id="submit" name="submit" type="buttom">Submit</button>
        <a href="delete_project.php?id=<?php echo $project->getId() ?>">
          <button class="btn btn-danger" type="button">Delete</button>
        </a>
      </form>
      <br/>
    </div>
    
  </div>
<?php
  }
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

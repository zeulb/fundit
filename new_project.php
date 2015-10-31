<?php
  session_start();
  date_default_timezone_set("Asia/Singapore");
  $current_page = 'Projects';
  include_once("controller/UserController.php");
  include_once("controller/ProjectController.php");

  if (!UserController\isSignedIn() || !UserController\isCreator($_SESSION["username"])) {
    header("Location: index.php");
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $goal = $_POST["goal"];
    $deadline = $_POST["deadline"];
    if (ProjectController\createNewProject($title, $description, $goal, $deadline)) {
      $message = "New project added";
      $message_type = "success";
    } else {
      $message = "Invalid date time format";
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
      <form method="post" class="form" role="form">
        <div class="form-group ">
          <label class="control-label" for="title">Title</label>
          <input class="form-control" id="title" name="title" required type="text" value="">
        </div>
        <div class="form-group ">
          <label class="control-label" for="description">Description</label>
          <textarea class="form-control" rows="10" id="description" name="description"></textarea>
        </div>
        <div class="form-group">
          <label class="control-label" for="deadline">Deadline</label>
          <div class='input-group date' id='deadline' >
              <input type='text' class="form-control" name="deadline" />
              <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
              </span>
          </div>
        </div>
        <script type="text/javascript">
          $('#deadline').datetimepicker({
            format: 'DD MMM YYYY hh:mm A'
          });
        </script>
        
        <div class="form-group ">
          <label class="control-label" for="goal">Goal</label>
          <div class='input-group date' id='goal' >
              <span class="input-group-addon">
                  <span class="glyphicon glyphicon-usd"></span>
              </span>
              <input type='text' class="form-control" name="goal" />
          </div>
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

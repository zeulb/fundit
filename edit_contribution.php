<?php
  session_start();
  $current_page = 'Projects';
  include_once "controller/ProjectController.php";
  include_once "controller/ContributionController.php";
  include_once "controller/UserController.php";

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $contribution = ContributionController\getContribution($id);
  }

  if (isset($contribution)) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $fund = $_POST["fund"];
      $timestamp = $_POST["timestamp"];

      $contribution->setAmount($fund);
      $contribution->setTimestamp($timestamp);

      $message = "Contribution updated";
      $message_type = "success";
    } else {
      $fund = $contribution->getAmount();
      $timestamp = $contribution->getDate();

    }
  } else {
    $message = "Contribution with id ".$id." not found";
    $message_type = "danger";
  }

  if (isset($contribution) && !UserController\canActiveUserModifyContribution($contribution->getId())) {
    unset($contribution);
    $message = "Cannot edit selected contribution";
    $message_type = "danger";
  }

?>

<?php ob_start(); ?>
  <br/>
  <div class="inner cover container">
    <div class="row">
      
      <?php
        include_once 'template/message.php';
      ?>

      <?php
        if (isset($contribution)) { ?>
      
      <form method="post" class="form" role="form">
        <div class="form-group ">
          <label class="control-label" for="fund">Fund</label>
          <div class='input-group date' id='fund' >
              <span class="input-group-addon">
                  <span class="glyphicon glyphicon-usd"></span>
              </span>
              <input type='text' class="form-control" name="fund" value="<?php echo $fund; ?>"/>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label" for="timestamp">Timestamp</label>
          <div class='input-group date' id='timestamp' >
              <input type='text' class="form-control" name="timestamp" value="<?php echo $timestamp; ?>" />
              <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
              </span>
          </div>
        </div>
        <script type="text/javascript">
          $(function () {
            $('#timestamp').datetimepicker({
              format: 'DD MMM YYYY hh:mm A'
            });
          });
        </script>
        <button class="btn btn-success" id="submit" name="submit" type="buttom">Submit</button>
        <a href="delete_contribution.php?id=<?php echo $contribution->getId() ?>">
          <button class="btn btn-danger" type="button">Delete</button>
        </a>
      </form>
      <br/>
      <?php
        }
      ?>
    </div>
  </div>
<?php
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

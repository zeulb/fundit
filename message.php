<?php
if (isset($message)) {
  ?>
  <div class="container">
    <div class="alert alert-<?php echo $message_type ?>" >
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $message ?>
  </div>
  <?php
}?>
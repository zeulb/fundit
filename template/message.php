<?php
if (isset($message)) {
  ?>
    <div class="alert alert-<?php echo $message_type ?>" style="width:100%;">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $message ?>
    </div>
  <?php
}?>
<?php
  session_start();
  $current_page = 'Project';
?>

<? ob_start(); ?>
  <br/>
  <div class="inner cover container">
    <div class="row">
      <h4 class = "text-left">Recent</h4>
    </div>
    <div class="row">
      <hr/>
      <div class="col-md-6">
        <h4 class = "text-left"> Jualan Anduk </h4>
        <p class = "text-left">
        by Anduk Budi
        · 
        5 funders
        </p>
      </div>
      <div class="col-md-6" align="right">
        <h4 class = "text-right"> $1000000 </h4>
        <button type="button" class="btn btn-success">Fund!</button>
      </div>
    </div>
    <div class="row">
      <hr/>
      <div class="col-md-3">
      <img src="http://4.bp.blogspot.com/-w7r-29KewTs/VCRnv7qKdiI/AAAAAAAAATw/epmv8yNKY6c/s1600/mika%2Btabung%2Bpolos.jpg"
        height=100px/>
      </div>
      <div class="col-md-5">
        <h4 class = "text-left"> Jualan Anduk </h4>
        <p class = "text-left">
        by Anduk Budi
        · 
        5 funders
        </p>
      </div>
      <div class="col-md-4" align="right">
        <h4 class = "text-right"> $1000000 </h4>
        <button type="button" class="btn btn-success">Fund!</button>
      </div>
    </div>
    <div class="row">
      <hr/>
    </div>
  </div>
<? 
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

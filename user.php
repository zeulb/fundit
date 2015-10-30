<?php
  session_start();
  $current_page = 'Contributors';
?>

<?php ob_start(); ?>
  <br/>
  <div class="inner cover container">
    <div class="row">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Total Contribution</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td align="left">1</td>
            <td align="left">Budi Anduk</td>
            <td align="left">$130303.00</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
<?php
  $content = ob_get_clean();
  include_once 'template/skeleton.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>FundIt!</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/cover.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">FundIt</h3>
              <nav>
                <ul class="nav masthead-nav">
                  <li><a href="index.php">Home</a></li>
                  <li><a href="project.php">Projects</a></li>
                  <li><a href="user.php">Contributors</a></li>
                  <li class="active"><a href="signin.php">Sign In</a></li>
                  <li><a href="signup.php">Sign Up</a></li>
                </ul>
              </nav>
            </div>
          </div>
          <br/>
          <div class="inner cover container">
            <div class="row">

              <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                  echo "POST COK";
              ?>
              
              <?php
                } else {
              ?>
              <form method="post" class="form" role="form">
                <div class="form-group ">
                  <label class="control-label" for="username">Username</label>
                  <input class="form-control" id="username" name="username" required type="text" value="">
                </div>
                <div class="form-group ">
                  <label class="control-label" for="password">Password</label>
                  <input class="form-control" id="password" name="password" required type="password" value="">
                </div>
                <button class="btn btn-success" id="submit" name="submit" type="buttom">Submit</button>
              </form>
              <?php
                }
              ?>
              <br/>
              <p>Want to sign up ? Click <a href="signup.php"> here </a></p>
            </div>
            
          </div>


          <div class="mastfoot">
            <div class="inner">
              <p>&copy Fundit 2015</p>
            </div>
          </div>

        </div>

      </div>

    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
<?php
session_start();

//Connect to Database
include 'connection.php';

//Remember Me code

include 'remember.php';

//Logout file_exists

include 'logout.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Online Notes</title>
    <meta charset="utf-8"/>
    <meta name="author" content="anunay anand"/>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!--Fonts-->        
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine|Hepta+Slab|Roboto|Bellota">
<!--Google icons-->
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<!--font awesome 5 icons-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<!-- font awesome 4 icons-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!--Personal Css file-->
<link rel="stylesheet" href="format.css" type="text/css">    
<!--Personal Js File-->    
<script src="index.js"></script>
    </head>
<body>
<header><!--navbar for website-->
   <nav class="navbar navbar-expand-md navbar-dark">
  <!-- Brand -->
       <a class="navbar-brand" href="index.php" style="font-size: 1.75rem;"><b>Online Notes</b></a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#NavbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="NavbarCollapse">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link active" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Help</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact us</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-toggle="modal" href="#loginModal">Login</a>
      </li>  
    </ul>  
  </div>
</nav>
</header><!--Jumbortron with signup Button-->
    <div class="container">
		<div class="jumbotron text-center">
			<h1 class="display-3">Online Notes App</h1>
			 <p class="lead">Your Notes with you wherever you go</p>
			     <p class="lead">Easy to use,protects all your notes!</p>			
             <button class="btn btn-lg mt-5 signup-btn" data-toggle="modal" data-target="#signupModal" type="button">Sign up-It's free</button>
               <!-- Button Modal Singup form-->
        </div>
    </div>    
<div class="container">    
    <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-12 bg-light mx-auto text-center">
          <!--SIGNUP FORM-->
        <form method="post" id="signupform">    
            <!-- The Modal -->
        <div class="modal" id="signupModal">
            <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Sign Up today and start using our Website!</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

          <!-- Modal body -->
        <div class="modal-body">
            <!--sign up message from php-->
            <div id="signupmessage"></div>
            <div class="form-group"> 
            <label for="name">Name:
                <input type="text" name="username" maxlength="30" class="form-control" placeholder="Username" id="username" required> 
                </label>
            </div>
            <div class="form-group">
            <label for="email">Email:
                <input type="email" name="email" maxlength="50" class="form-control" placeholder="Email" id="email" required> 
                </label>
            </div>
            <div class="form-group">
            <label for="password">Password:
                <input type="password" name="password" maxlength="30" class="form-control" placeholder="password" id="password" required> 
                </label>
            </div>
            <div class="form-group">
            <label for="password2">Confirm Password:
                <input type="password" name="password2" maxlength="30" class="form-control" placeholder="confirm password" id="password2" required> 
                </label>
            </div>
        </div>
            
          <!-- Modal footer -->
        <div class="modal-footer">
            <input type="submit" class="btn btn-success" name="signup" value="signup"/>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
    </div>
  </div>
</div>
        </form>
        </div>
    </div>
</div><!--LOGIN FORM-->
    <div class="container">    
    <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-12 bg-light mx-auto text-center">
          <!--FORM-->
        <form method="post" id="loginform">   
            <!-- The Modal -->
        <div class="modal" id="loginModal">
            <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Login:</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

          <!-- Modal body -->
        <div class="modal-body">
            <!--login message from php-->
            <div id="loginmessage"></div>
            <div class="form-group">
            <label for="email">Email:
                <input type="email" name="loginemail" maxlength="50" class="form-control" placeholder="Email" id="loginemail" required> 
                </label>
            </div>
            <div class="form-group">
            <label for="password">Password:
                <input type="password" name="loginpassword" maxlength="30" class="form-control" id="loginpassword" placeholder="password" required> 
                </label>
            </div>
            <div class="checkbox">
                <label>
                <input type="checkbox" name="rememberme" id="rememberme"/>
                Remember Me    
                </label>
                <a href="#forgotpasswordModal" data-toggle="modal" class="pull-right" data-dismiss="modal">Forgot Password?</a>
            </div>
        </div>
            
          <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-primary mr-auto" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
            <input type="submit" class="btn btn-success" name="login" value="login"/>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
    </div>
  </div>
</div>
        </form>    
        </div>
    </div>
</div>
    <!-- Forgot password Modal-->
<div class="container">    
    <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-12 bg-light mx-auto text-center">
          <!--FORM-->
        <form method="post" id="forgotpasswordform">    
            <!-- The Modal -->
        <div class="modal" id="forgotpasswordModal">
            <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Forgot Password? Enter your Email Address:</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

          <!-- Modal body -->
        <div class="modal-body">
            <!--sign up message from php-->
            <div id="forgotpasswordmessage"></div>
            <div class="form-group">
            <label for="forgotemail">Email:
                <input type="email" name="forgotemail" maxlength="50" class="form-control" placeholder="Email" id="forgotemail" required> 
                </label>
            </div>
        </div>
            
          <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-primary mr-auto" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
            <input type="submit" class="btn btn-success" name="forgotpassword" value="submit">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
    </div>
  </div>
</div>
        </form>    
        </div>
    </div>
</div>    <!--Footer-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 footer text-center">
                <p class="">Development Island.com Copyright &copy; 2015 - <?php $today=date("Y"); echo $today;?>.</p>
            </div>
        </div>
    </div>
    </body>
</html>
<?php
session_start();
//to check if the user is logged out
if(!isset($_SESSION['user_id'])){
header("location:index.php");    
}
//Fetch user_id
$id= $_SESSION['user_id'];
//Connect to Database if user_id is defined.
include 'connection.php';
//Query to Fetch the username
$sql = "SELECT username FROM myguests WHERE user_id='$id'";
$result = mysqli_query($conn,$sql);
if(!$result){
    echo "<div>There was an Error fetching username.</div>";
}
$count = mysqli_num_rows($result);
if($count !== 1){
    echo "<div>There was an Error fetching username.</div>";
    exit();
}
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$_SESSION['username'] = $row['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Notes</title>
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
<!--Personal Js File-->    
<script src="index.js"></script>   
<!-- Notes js-->    
<script src="mynotes.js"></script>      
<!--Personal Css file-->
<link rel="stylesheet" href="format.css" type="text/css">    
    </head>
<body>    
<header><!--navbar for website-->
   <nav class="navbar navbar-expand-md navbar-dark">
  <!-- Brand -->
       <a class="navbar-brand" href="mainpagelogin.php" style="font-size: 1.75rem;"><b>Online Notes</b></a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#NavbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="NavbarCollapse">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="profile.php">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Help</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact us</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="mainpagelogin.php">My Notes</a>
      </li>    
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">Logged in as <b><?php echo $_SESSION['username']; ?></b></a>
      </li>      
      <li class="nav-item">
        <a class="nav-link" href="index.php?logout=1">Log out</a>
      </li>  
    </ul>  
  </div>
</nav>
</header><!--Notes-->
    <div class="container Notes-container">
        <div class="row">
            <div class="col-md-8 offset-md-2 col-sm-12 w-100">   
                <!-- Collapsible Error box-->
	           <div class="collapse alert alert-danger" id="alert">
                    <a class="close" href="#alert" data-toggle="collapse" data-dismiss="alert">&times;</a>
                    <p id="alertcontent"></p>
	           </div>
                <!--Button Notes function-->
                <div class="buttons mb-3 w-100">
                    <button id="addNote" class="btn btn-info" type="button">Add Note</button>
                    <button id="allNotes" class="btn btn-info" type="button">All Notes</button>
                    <button id="edit" class="btn btn-info float-right" type="button">Edit</button>
                    <button id="done" class="btn btn-success float-right" type="button">Done</button>
                </div><!--Notepad to write-->
                <div id="notepad">
                    <textarea rows="10" class="w-100" id="textarea"></textarea>
                </div>
                <!-- Saved Notes-->
                <div id="notes" class="notes">
                <!-- Ajax call to php file to load the notes-->
                </div>
            </div>
        </div>     
    </div> 
    <!-- Button Modal Singup form-->    
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
            <!--sign up message from php-->
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
            <input type="submit" class="btn btn-success" name="forgotpassword" value="submit"/>
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
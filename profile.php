<?php
//session start
session_start();
//check wether session id is there or Not
if(!isset($_SESSION['user_id'])){
header("location: index.php");
}
//connect to database
include 'connection.php';    
//Fetch the userid from session
$user_id = $_SESSION['user_id'];
//Run query to get username from Database
$sql = "SELECT * FROM myguests WHERE user_id='$user_id'";    
$result = mysqli_query($conn,$sql);
if(!$result){
echo "<div class='alert alert-danger'>something is wrong</div>";
}
//To store the number of rows        
$count = mysqli_num_rows($result);
    if($count == 1){
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        //We have got access to the only Row we wanted
        $username = $row['username'];
        $email = $row['email'];
    }
    else{
        echo "There was an error retreiving";
    }    
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
<!--Personal Css file-->
<link rel="stylesheet" href="format.css" type="text/css">    
<!--Personal Js File-->    
<script src="index.js"></script>
<!--Js file especially for profile page-->
<script src="profile.js"></script>    
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
        <a class="nav-link active" href="#">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Help</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact us</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="mainpagelogin.php">My Notes</a>
      </li>    
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">Logged in as <b><?php echo $username; ?></b></a>
      </li>      
      <li class="nav-item">
        <a class="nav-link" href="index.php?logout=1">Log out</a>
      </li>  
    </ul>  
  </div>
</nav>
</header><!--Profile Page-->
    <div class="container profile-Container">
        <div class="row">
            <div class="col-md-8 offset-md-2 col-sm-12 w-100">
                <h2>General Account Settings:</h2>   
                <!--Profile Table-->
                <div class="table-responsive-md">
                    <table class="table table-hover table-bordered">
       <tbody>
           <tr role="button" data-target="#updateusername" data-toggle="modal">
                <!--Username Row-->
               <td>Username</td>
               <td><?php echo $username; ?></td>
           </tr>
           <tr role="button" data-target="#updateEmail" data-toggle="modal">
               <!--Email Row-->
               <td>Email</td>
               <td><?php echo $email; ?></td>
           </tr>
           <tr role="button" data-target="#updatePassword" data-toggle="modal">
               <!--Password Row-->
               <td>Password</td>
               <td>Hidden</td>
               </tr>
       </tbody>
    </table>
</div>

            </div>
        </div>     
    </div>     
<!--Update Username-->
    <div class="container">    
    <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-12 bg-light mx-auto text-center">    
          <!--FORM-->
        <form method="post" id="updateusernameform">   
            <!-- The Modal -->
        <div class="modal" id="updateusername">
            <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Update Username:</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

          <!-- Modal body -->
        <div class="modal-body">
          <!--Error message from php-->
	       <div id="usernamemessage"></div>
            <div class="form-group">
            <label for="username">Username:
                <input type="text" name="username" maxlength="50" class="form-control" id="username" value="<?php echo $username; ?>"> 
                </label>
            </div>
        </div>
            
          <!-- Modal footer -->
        <div class="modal-footer">
            <input type="submit" class="btn btn-success" name="updateusername" value="submit"/>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
    </div>
  </div>
</div>
        </form>
         <!--FORM for Updating Mail-->
        <form method="post" id="updateemailform">   
            <!-- The Modal -->
        <div class="modal" id="updateEmail">
            <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Enter new email:</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

          <!-- Modal body -->
        <div class="modal-body">
            <!--sign up message from php-->
            <div id="updateemailmessage"></div>
            <div class="form-group">
            <label for="username">Email:
                <input type="email" name="email" maxlength="50" class="form-control" id="email" value="<?php echo $email; ?>"> 
                </label>
            </div>
        </div>
            
          <!-- Modal footer -->
        <div class="modal-footer">
            <input type="submit" class="btn btn-success" name="updateemail" value="submit"/>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
    </div>
  </div>
</div>
        </form>
          <!--FORM for Updation of Password-->
        <form method="post" id="updatepasswordform">   
            <!-- The Modal -->
        <div class="modal" id="updatePassword">
            <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Enter Current and New password:</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

          <!-- Modal body -->
        <div class="modal-body">
            <!--update password message from php-->
            <div id="passwordmessage"></div>
            <div class="form-group">
            <label for="currentpassword">
                <input type="password" name="currentpassword" maxlength="50" class="form-control" placeholder="Your current password" id="currentpassword"> 
                </label>
            </div>
            <div class="form-group">
            <label for="newpassword">
                <input type="password" name="password" maxlength="50" class="form-control" placeholder="Your New password" id="password"> 
                </label>
            </div><div class="form-group">
            <label for="newpassword">
                <input type="password" name="password2" maxlength="50" class="form-control" placeholder="Your New password" id="password2"> 
                </label>
            </div>
        </div>
            
          <!-- Modal footer -->
        <div class="modal-footer">
            <input type="submit" class="btn btn-success" name="updatepassword" value="submit"/>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
    </div>
  </div>
</div>
        </form>    
        </div>
    </div>
</div>  
     <!--Footer-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 footer text-center">
                <p class="">Development Island.com Copyright &copy; 2015 - <?php $today=date("Y"); echo $today;?>.</p>
            </div>
        </div>
    </div>
    </body>
</html>
//Ajax call for signup Form
//Once form is submitted
$(document).ready(function () {
    $("#signupform").submit(function () {
    event.preventDefault();
    //Collect user Input
    var datapost = $("#signupform").serialize();   
    //send them to signup.php using Ajax
        $.ajax({
        url: "signup.php",
        type: "POST",
        data: datapost,
        success: function(data){
            if(data){
            $("#signupmessage").html(data);
            }
        },
        error: function(){
            $("#signupmessage").html("<div class='alert alert-danger'>There was some error in Ajax call please try again Later.</div>");
            }    
        });    
    });
});
//Ajax call for Login form
$(document).ready(function () {
    $("#loginform").submit(function () {
        event.preventDefault();
    //Collect data from Login form
        var datatopost = $("#loginform").serialize();
        //send them into login.php by using ajax
        $.ajax({
            url: "login.php",
            type: "POST",
            data: datatopost,
            success: function(data){
                if(data.length <= 13){  //I dont know why the strlen of success is coming 13.
                window.location.replace("mainpagelogin.php");   
                }
                else{
                    $("#loginmessage").html(data);
                }
            },
            error: function () {
            $("#loginmessage").html("<div class='alert alert-danger'>There was some error in Ajax call please try again later </div>")
            }
        });
    });
});
//Ajax call for forget password
$(document).ready(function () {
    $("#forgotpasswordform").submit(function () {
    event.preventDefault();
    //Collect user Input
    var datapost = $("#forgotpasswordform").serialize();   
    //send them to signup.php using Ajax
        $.ajax({
        url: "forgot.php",
        type: "POST",
        data: datapost,
        success: function(data){
            if(data){
            $("#forgotpasswordmessage").html(data);
            }
        },
        error: function(){
            $("#signupmessage").html("<div class='alert alert-danger'>There was some error in Ajax call please try again Later.</div>")
            }    
        });    
    });
});
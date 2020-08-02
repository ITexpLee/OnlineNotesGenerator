$(document).ready(function () {
    //Ajax code to update username
    //prevent the default action of form
    $("#updateusernameform").submit(function (event) {
        event.preventDefault();
    //Get the value of element from the form    
        var datatopost = $(this).serialize();    
    //send the value to php file through Ajax
        $.ajax({
            url: "updateusername.php",
            type: "POST",
            data: datatopost,
            success: function(data){
                if(data){
                    $("#usernamemessage").html(data);
                }
                else{
                    location.reload();
                }
            },
            error: function(){
                $("#usernamemessage").html("<div class='alert alert-danger'>There was an error excecuting the Ajax call.</div>");
            }
        });
    });
    //Ajax code to update password
    //prevent the default action of form
    $("#updatepasswordform").submit(function (event) {
        event.preventDefault();
    //Get the value of element from the form    
        var datatopost = $(this).serialize();    
    //send the value to php file through Ajax
        $.ajax({
            url: "updatepassword.php",
            type: "POST",
            data: datatopost,
            success: function(data){
                if(data){
                    $("#passwordmessage").html(data);
                }
            },
            error: function(){
                $("#passwordmessage").html("<div class='alert alert-danger'>There was an error excecuting the Ajax call.</div>");
            }
        });
    });
     //Ajax code to update Email
    //prevent the default action of form
    $("#updateemailform").submit(function (event) {
        event.preventDefault();
    //Get the value of element from the form    
        var datatopost = $(this).serialize();    
    //send the value to php file through Ajax
        $.ajax({
            url: "updateEmail.php",
            type: "POST",
            data: datatopost,
            success: function(data){
                if(data){
                    $("#updateemailmessage").html(data);
                }
            },
            error: function(){
                $("#updateemailmessage").html("<div class='alert alert-danger'>There was an error excecuting the Ajax call.</div>");
            }
        });
    });
      
});



//Ajax code to update email
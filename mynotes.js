$(document).ready(function () {
    //define variables
        var activeNote = 0;
        var editMode = false;
        //load notes only on page load:ajax call to loadnotes file
        $.ajax({
            url: "loadnotes.php",
            success: function (data){
                $('#notes').html(data);
                //If you want to edit a function
                clickonNote();
                clickonDelete();
            },
            error: function(){
                $("#alertcontent").text("There was an error with the ajax call.Please try again!");
                    $("#alert").fadeIn();
            }
        });
            //add new note: ajax call to another file to add new note
$("#addNote").click(function(){
    $.ajax({
        url: "createnote.php",
        success: function(data){
            if(data == 'error'){
                $("#alertcontent").text("There was an issue inserting the new Note in Database!");
                $("#alert").fadeIn();
            }
            else{
                //update the varibale active note to id to current note
                activeNote = data;
                //Prepare the homepage for typing
                    $("textarea").val("");
                    //show and hide element ['this','is','will','array','1'],['this','is','array 2'],[this is array 3]....
                    showHide(['#notepad','#allNotes'],['#addNote','#edit','#notes','#done']);
                    $("textarea").focus();
                }
            },
        error: function(){
                $("#alertcontent").text("There was an error with the ajax call.Please try again!");
                    $("#alert").fadeIn();
            }
    });
});    
            //type note: ajax call to update a notes file
                
                $("textarea").keyup(function () {
                    //ajax call to update the task of id active note.
                     $.ajax({
                            url: "updatenote.php",
                            type: "POST",
                            //we need to send data of current Note content with id to php file
                            //Here we use an object to send data. An array is also form of object. In object name is used to call value.
                            data: {note: $(this).val(), id:activeNote},
                            success: function (data){
                                if(data){
                                }
                            },
                            error: function(){
                                $("#alertcontent").text("There was an error with the ajax call.Please try again!");
                                $("#alert").fadeIn();
                            }

                    });
                });
                //click on all notes button
                    $("#allNotes").click(function () {
                        $.ajax({
                            url: "loadnotes.php",
                            success: function (data){
                                $('#notes').html(data);
                                //show some and hide certain elements
                                showHide(['#addNote','#edit','#notes'],['#notepad','#allNotes']);
                                //We need to add function for updation of note here cause after click on all notes load notes function is done working so we will add it here as Well.
                                clickonNote();
                                clickonDelete();
                            },
                            error: function(){
                                $("#alertcontent").text("There was an error with the ajax call.Please try again!");
                                $("#alert").fadeIn();
                            }
                        });        
                    });
                        //done button after editing
                            $("#done").click(function () {
                                //swtich to non Edit mode
                                editMode = false;
                                //expand our notes to normal form
                                $(".note").removeClass('row');
                                $(".noteheader").removeClass('col-xs-7 col-sm-9');
                                //hide show method
                                showHide(['#edit'],[this,'.delete',]);
                            });
                        //click on edit button
                        $("#edit").click(function () {
                            //Switch to Edit Mode
                            editMode = true;
                            //To reduce the width of Notes
                            $(".note").addClass('row');
                        $(".noteheader").addClass('col-xs-7 col-sm-9');        
                            //use the show hide function on entering edit mode
                        showHide(['#done','.delete'],['#edit']);    
                        });
            //functions
                //clicking in a note
                    function clickonNote(){
                        $(".noteheader").click(function(){
                            if(!editMode){
                                //update active not var 
                                activeNote = $(this).attr("id");
                                //fill text area now
                                $("textarea").val($(this).find('.text').text());
                                //show and hide elements
                                showHide(['#notepad','#allNotes'],['#addNote','#edit','#notes','#done']);
                                $("textarea").focus();
                            }
                        });
                    }
                //clicking on delete button
            function clickonDelete(){
                    $(".delete").click(function () {
                        var deleteButton = $(this);
                        //send ajax call to delete Note from Database
                            $.ajax({
                            url: "deletenote.php",
                            type: "POST",
                            data: {id:deleteButton.next().attr('id')},    
                            success: function (data){
                                if(data == 'error'){
                                  $("#alertContent").text("There was an issue deleting the note in Database.");
                                    $("#alert").fadeIn();
                                }
                                else{
                                    //Delete the containing div.
                                    deleteButton.parent().remove();
                                }
                            },
                            error: function(){
                                $("#alertcontent").text("There was an error with the ajax call.Please try again!");
                                $("#alert").fadeIn();
                            }
                        });  
                        
                                
                    });
            }
                //show hide function
            function showHide(array1, array2){
                    for(i=0;i<array1.length;i++){
                        $(array1[i]).show();
                    }
                    for(i=0;i<array2.length;i++){
                        $(array2[i]).hide();
                    }
                }
            
});
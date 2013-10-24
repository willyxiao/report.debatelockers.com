<?php

    // configuration
    require("../includes/config.php"); 
   
    // if form was submitted
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        // if asking to delete, then delete
        if(isset($_POST["del"]))
        {
            query("DELETE FROM email_updates WHERE school_id=? AND email_email=?", $_SESSION["id"], $_POST["del"]); 
        }
        // else if toggle on, then toggle 
        else if(isset($_POST["toggle_on"]))
        {
            query("UPDATE email_updates SET email_on=1 WHERE school_id=? AND email_email=?", $_SESSION["id"], $_POST["toggle_on"]);
        }
        // else toggle off
        else
        {
            query("UPDATE email_updates SET email_on=0 WHERE school_id=? AND email_email=?", $_SESSION["id"], $_POST["toggle_off"]);
        }
    
        // go to the teams page again
        redirect("updates.php"); 
    }
    else
    {
        // go to homepage
        redirect("/"); 
    }    

?>

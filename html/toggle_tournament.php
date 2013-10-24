<?php

    // configuration
    require("../includes/config.php"); 
   
    // if form was submitted
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // if asking to delete, then delete
        if(isset($_POST["del"]))
        {
            query("UPDATE attendance SET attend_del=1 WHERE school_id=? AND tournament_id=?", $_SESSION["id"], $_POST["del"]); 
        }
        // else if toggle on, then toggle 
        else if(isset($_POST["toggle_on"]))
        {
            query("UPDATE attendance SET attend_on=1 WHERE school_id=? AND tournament_id=?", $_SESSION["id"], $_POST["toggle_on"]);
        }
        // else toggle off
        else
        {
            query("UPDATE attendance SET attend_on=0 WHERE school_id=? AND tournament_id=?", $_SESSION["id"], $_POST["toggle_off"]); 
        }
    
        // go to the tournaments page again
        redirect("tournaments.php"); 
    }
    else
    {
        // go to homepage
        redirect("/"); 
    }    

?>

<?php

    // configuration
    require("../includes/config.php"); 
   
    // if form was submitted
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // if asking to delete, then delete
        if(isset($_POST["del"]))
        {
            query("UPDATE teams SET team_del=1 WHERE team_id=?", $_POST["del"]); 
        }
        // else if toggle on, then toggle 
        else if(isset($_POST["toggle_on"]))
        {
            query("UPDATE teams SET team_on=1 WHERE team_id=?", $_POST["toggle_on"]);
        }
        // else toggle off
        else
        {
            query("UPDATE teams SET team_on=0 WHERE team_id=?", $_POST["toggle_off"]); 
        }
    
        // go to the teams page again
        redirect("teams.php"); 
    }
    else
    {
        // go to homepage
        redirect("/"); 
    }    

?>

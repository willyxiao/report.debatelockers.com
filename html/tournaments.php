<?php

    // configuration
    require("../includes/config.php");
    
    // checks if form was submitted
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // sees if this tournament exists now
        $attended = query("SELECT * FROM attendance WHERE school_id=? AND tournament_id=?", $_SESSION["id"], $_POST["tournament"]); 
        
        // if it does exist, turn the tournament back on
        if(!empty($attended))
        {
            query("UPDATE attendance SET attend_del=0, attend_on=1 WHERE school_id=? AND tournament_id=?", $_SESSION["id"], $_POST["tournament"]); 
        }
        else
        {
            // inserts tournament into database
            query("INSERT INTO attendance (school_id, tournament_id) VALUES (?, ?)", $_SESSION["id"], $_POST["tournament"]);
        }
        
        // back to homepage
        redirect("/"); 
    }    
    // else
    else
    {
        // gets information from database
        $attends = query("SELECT * FROM attendance JOIN tournaments ON attendance.tournament_id=tournaments.tournament_id WHERE school_id = ? AND attend_del!=1", $_SESSION["id"]);
        $tournaments = query("SELECT * FROM tournaments WHERE tournament_year >= ? ORDER BY tournament_name", date("Y", time()));
        
        render("tournament_form.php", array("title" => "Tournaments", "attends" => $attends, "tournaments" => $tournaments)); 
    }
    
?>

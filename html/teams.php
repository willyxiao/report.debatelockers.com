<?php

    // configuration
    require("../includes/config.php");
    
    // checks if form was submitted
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // checks if all forms will filled out
        if(empty($_POST["name1"]) || empty($_POST["name2"]))
        {
            apologize("Enter both names. If maverick, enter same name twice"); 
        }
        
        // if string is more than one word, apologize
        else if(strpos($_POST["name1"], " ") !== false || strpos($_POST["name2"], " ") !== false)
        {
            apologize("Last name only. No spaces");
        }
        
        // capitalizes the names
        $name1 = strtoupper($_POST["name1"]);
        $name2 = strtoupper($_POST["name2"]);
        
        // puts the names in alphabetical order
        if(strcmp($name1, $name2) > 0)
        {
            $tmp = $name1; 
            $name1 = $name2; 
            $name2 = $tmp;
        }
        
        // query server with the current teams of the school
        $teams = query("SELECT * FROM teams WHERE school_id = ?", $_SESSION["id"]); 
        
        // checks if the team already exists for the school
        if(isset($teams[0]))
        {
            foreach($teams as $team)
            {
                if(($name1 == $team["team_name1"] && $name2 == $team["team_name2"]) || ($name1 == $team["team_name2"] && $name2 == $team["team_name1"]))
                {
                    // if the team hasn't been deleted, apologize
                    if($team["team_del"] != 1)                    
                        apologize("Team already exists");
                    // if the team was deleted, reset the team and redirect to homepage
                    else
                    {
                        query("UPDATE teams SET team_del=0 WHERE team_id = ?", $team["team_id"]);
                        redirect("/");  
                    } 
                }
            }
        }
        
        // adds team into the database
        query("INSERT INTO teams (school_id, team_name1, team_name2) VALUES (?, ?, ?)", $_SESSION["id"], $name1, $name2); 
        
        // redirects to homepage
        redirect("/");         
    }
    
    // else renders form
    else
    {
        // gets all of the teams that are on
        $on_teams = query("SELECT * FROM teams WHERE school_id=? AND team_on=1 AND team_del !=1 ORDER BY team_name1", $_SESSION["id"]);
        
        // gets all of the teams that are off
        $off_teams = query("SELECT * FROM teams WHERE school_id=? AND team_on!=1 AND team_del !=1 ORDER BY team_name1", $_SESSION["id"]); 
        
        render("team_form.php", array("title"=> "Teams", "on_teams" => $on_teams, "off_teams" => $off_teams)); 
    }
    
?>

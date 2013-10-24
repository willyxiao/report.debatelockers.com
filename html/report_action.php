<?php
    // configuration
    require("../includes/config.php"); 
    
    // if form was submitted
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // if asked to view
        if(isset($_POST["round_v"]))
        {
            // gets all of the information from the tables
            $all = query("SELECT * FROM reports JOIN (teams, tournaments, judges) ON (reports.team_id=teams.team_id AND reports.tournament_id=tournaments.tournament_id AND reports.judge_id=judges.judge_id) WHERE report_id=?", $_POST["round_v"]); 

            // gets the judges from the database
            $judges[0] = query("SELECT reports.judge_id, judges.judge_first, judges.judge_last FROM reports JOIN judges ON reports.judge_id=judges.judge_id WHERE report_id=?", $_POST["round_v"]);
           
            // removes first layer
            $judges[0] = $judges[0][0];  

            // gets the rest of the judges and removes layer
            for($i = 1; $i < 5; $i++)
            {            
                $judges[$i] = query("SELECT reports.judge" . $i . "_id, judges.judge_first, judges.judge_last FROM reports JOIN judges ON reports.judge" . $i . "_id=judges.judge_id WHERE report_id=?", $_POST["round_v"]);
                
                if(isset($judges[$i][0]))
                {
                    $judges[$i] = $judges[$i][0];  
                }
                else
                {
                    unset($judges[$i]); 
                }
            }
            
            // gets rid of the first layer
            $all = $all[0]; 
                        
            // renders the editing form
            render("edit_form.php", array("all" => $all, "judges" => $judges)); 
        }
        
        // else must be asking to delete
        else
        {
            query("DELETE FROM reports WHERE report_id =?", $_POST["round_d"]);
            
            // redirects to search form
            redirect("quick.php"); 
        }
    }
    else
    {
        redirect("/"); 
    }

?>

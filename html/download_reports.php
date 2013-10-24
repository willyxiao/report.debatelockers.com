<?php
    // configuration
    require("../includes/config.php"); 
    
    // if the desired rounds was searched 
    if(!isset($_POST["Searched"]))
    {     
        // gets all of the information from all rounds
        $rounds = query("SELECT teams.team_name1, teams.team_name2, tournaments.tournament_name, tournaments.tournament_year, reports.round_num, reports.report_side, reports.report_opp, reports.report_result, reports.judge_id, reports.judge1_id, reports.judge2_id, reports.judge3_id, reports.judge4_id, reports.report_aff, reports.report_1nc, reports.report_2nc, reports.report_1nr, reports.report_2nr, reports.report_aff_strat, reports.report_comments FROM reports JOIN (teams, tournaments) ON (reports.team_id=teams.team_id AND reports.tournament_id=tournaments.tournament_id) WHERE reports.school_id=? ORDER BY teams.team_name1, tournaments.tournament_year DESC, tournaments.tournament_name, reports.round_num", $_SESSION["id"]); 
    }
    else
    {
        // makes the select statement
        $select = "SELECT teams.team_name1, teams.team_name2, tournaments.tournament_name, tournaments.tournament_year, reports.round_num, reports.report_side, reports.report_opp, reports.report_result, reports.judge_id, reports.judge1_id, reports.judge2_id, reports.judge3_id, reports.judge4_id, reports.report_aff, reports.report_1nc, reports.report_2nc, reports.report_1nr, reports.report_2nr, reports.report_aff_strat, reports.report_comments FROM reports JOIN (teams, tournaments) ON (reports.team_id=teams.team_id AND reports.tournament_id=tournaments.tournament_id) WHERE reports.school_id='" . $_SESSION["id"] . "' AND (";
        
        // makes the order statement
        $order = "ORDER BY teams.team_name1, tournaments.tournament_year DESC, tournaments.tournament_name, reports.round_num";
        
        // initializes variable to store ids
        $ids = ""; 
        
        // gets last key in searched
        end($_POST["Searched"]);
        $last_key = key($_POST["Searched"]); 
            
        // adds the report to the id string
        foreach($_POST["Searched"] as $key => $id)
        {
            if($key != $last_key)
            {
                $ids .= "reports.report_id='" . $id . "' OR ";
            }
            else
            {
                $ids .= "reports.report_id='" . $id . "') "; 
            }
        }
        
        // gets the rounds from the database
        $rounds = query($select . $ids . $order); 
            
    }
        
    // makes rounds displayable
    $rounds = make_displayable($rounds, "multiple"); 
        
    // creates name of csv file
    $csv_name = "../downloads/csv/" . $_SESSION["school_name"] . date("Y") . "-" . date("m") . "-" .  date("d") . "-" . date("H") . "." . date("i") . ".csv"; 
                    
    // opens the file
    $csv = fopen($csv_name, "w"); 
        
    // writes all information to the file
    foreach($rounds as $round)
    {
        fputcsv($csv, $round, ',', '"'); 
    }
        
    // closes file
    fclose($csv);      
        
    // gets base name of file
    $base_name = basename($csv_name); 

    // download files
    header("Content-Description: File Download"); 
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$base_name\"");
    header("Pragma: public");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Length: " . filesize($csv_name)); 
    readfile($csv_name);           
?>

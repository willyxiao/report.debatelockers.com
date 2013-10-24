<?php

    // configuration
    require("../includes/config.php");
    
    // get rounds from database
    $rounds = query("SELECT reports.report_result, reports.report_side, reports.report_opp, reports.report_id, reports.judge1_id, judges.judge_last, tournaments.tournament_name, reports.round_num, teams.team_name1, teams.team_name2, tournaments.tournament_year FROM reports JOIN (teams, tournaments, judges) ON (reports.team_id=teams.team_id AND reports.tournament_id=tournaments.tournament_id AND reports.judge_id=judges.judge_id) WHERE reports.school_id=? ORDER BY report_id LIMIT 200", $_SESSION["id"]); 
    
    // makes the rounds displayable
    $rounds = make_displayable($rounds, "single"); 
        
    // render
    render("show_reports.php", array( "title"=>"Quick Search", "type"=>"Reports [Last 200]", "rounds"=>$rounds)); 
?>

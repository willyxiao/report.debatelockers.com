<?php

    // configuration
    require("../includes/config.php");

    // gets the teams
    $teams = query("SELECT * FROM teams WHERE school_id = ? AND team_on=1 AND team_del!=1 ORDER BY team_name1", $_SESSION["id"]); 

    // gets the tournaments
    $tournaments = query("SELECT * FROM attendance JOIN tournaments ON attendance.tournament_id = tournaments.tournament_id WHERE attendance.school_id = ? AND attendance.attend_on=1 AND attendance.attend_del!=1 ORDER BY tournaments.tournament_name", $_SESSION["id"]); 

    // renders the report
    render("report_form.php", array("teams"=>$teams, "tournaments"=>$tournaments));
?>

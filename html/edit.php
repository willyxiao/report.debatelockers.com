<?php
    // configuration
    require("../includes/config.php"); 
    
    // if form was submitted
    if($_SERVER["REQUEST_METHOD"] == "POST")
    { 
        // checks if required fields were submitted
        if(empty($_POST["team"]) || empty($_POST["tournament"]) || empty($_POST["round"]) || empty($_POST["side"]) || empty($_POST["opp"]) || empty($_POST["result"]) || empty($_POST["judges"]))
        {
            apologize("Fill out required fields."); 
        }

        // checks if the length of words is overkill
        if(strlen($_POST["opp"]) > 30 || strlen($_POST["aff"]) > 1000 || strlen($_POST["1nc"]) > 1000 || strlen($_POST["2nc"]) > 1000 || strlen($_POST["1nr"]) > 1000 || strlen($_POST["2nr"]) > 1000 || strlen($_POST["aff_strat"]) > 1000 || strlen($_POST["comments"]) > 10000 || $_POST["judges"] > 150)
        {
            apologize("Length of a field is too long."); 
        }

        // capitalizes all strings
        $_POST["opp"] = strtoupper($_POST["opp"]);
        $_POST["judges"] = strtoupper($_POST["judges"]); 
             
        // checks if the round has already been submitted
        $round = query("SELECT * FROM reports WHERE team_id=? AND tournament_id=? AND round_num=?", $_POST["team"], $_POST["tournament"], $_POST["round"]);         
        
        // if it already exists
        if(isset($round[0]))
        {
            // and it isn't the round in question
            if($round[0]["report_id"] != $_POST["report_id"])
            {
                apologize("Round already exists."); 
            }
        }
        
        //checks if the opponent name is correct format
        $pos = strpos($_POST["opp"], " "); 
        if($pos !== false)
        {
            $pos2 = strpos($_POST["opp"], " ", $pos + 1); 
            if($pos2 !== false)
            {
                apologize("Opponent Format: [school] [initials]");
            }
        }
        else
        {
            apologize("Opponent Format: [school] [initials]");
        }

        // gets the names of all of the judges
        $judges = get_judges($_POST["judges"]); 
        
        // gets the judge id's from all of the judge names
        $judges = get_judge_ids($judges);
             
        // updates the database
        query("UPDATE reports SET team_id=?, tournament_id=?, round_num=?, report_side=?, report_opp=?, report_result=?, judge_id=?, judge1_id=?, judge2_id=?, judge3_id=?, judge4_id=?, report_aff=?, report_1nc=?, report_2nc=?, report_1nr=?, report_2nr=?, report_aff_strat=?, report_comments=? WHERE report_id=?", $_POST["team"], $_POST["tournament"], $_POST["round"], $_POST["side"], $_POST["opp"], $_POST["result"], $judges[0], $judges[1], $judges[2], $judges[3], $judges[4], $_POST["aff"], $_POST["1nc"], $_POST["2nc"], $_POST["1nr"], $_POST["2nr"], $_POST["aff_strat"], $_POST["comments"], $_POST["report_id"]);
        
        // redirect
        redirect("quick.php"); 
    }
    else
    {
        // redirect to homepage
        redirect("/"); 
    }
?>

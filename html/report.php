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

        // checks the length of each field
        if(strlen($_POST["opp"]) > 30 || strlen($_POST["aff"]) > 1000 || strlen($_POST["1nc"]) > 1000 || strlen($_POST["2nc"]) > 1000 || strlen($_POST["1nr"]) > 1000 || strlen($_POST["2nr"]) > 1000 || strlen($_POST["aff_strat"]) > 1000 || strlen($_POST["comments"]) > 30000 || $_POST["judges"] > 150)
        {
            apologize("Length of a field is too long."); 
        }
        
        // capitalizes all strings
        $_POST["opp"] = strtoupper($_POST["opp"]);
        $_POST["judges"] = strtoupper($_POST["judges"]); 
     
        // checks if the round has already been submitted
        $round = query("SELECT * FROM reports WHERE team_id=? AND tournament_id=? AND round_num=?", $_POST["team"], $_POST["tournament"], $_POST["round"]);         
        
        // if it has already been submitted, apologize
        if(isset($round[0]))
        {
            apologize("Round already exists."); 
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
        
        // submit the round into the database
        query("INSERT INTO reports (school_id, team_id, tournament_id, round_num, report_side, report_opp, report_result, judge_id, judge1_id, judge2_id, judge3_id, judge4_id, report_aff, report_1nc, report_2nc, report_1nr, report_2nr, report_aff_strat, report_comments) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $_SESSION["id"], $_POST["team"], $_POST["tournament"], $_POST["round"], $_POST["side"], $_POST["opp"], $_POST["result"], $judges[0], $judges[1], $judges[2], $judges[3], $judges[4], $_POST["aff"], $_POST["1nc"], $_POST["2nc"], $_POST["1nr"], $_POST["2nr"], $_POST["aff_strat"], $_POST["comments"]);
        
        /** sends emails **/
        
        // gets all of the emails that need to be notified
        $emails = query("SELECT email_email FROM email_updates WHERE school_id=? AND email_on = 1", $_SESSION["id"]);
        
        // gets all of the sms text numbers that need to be notified
        $texts = query("SELECT * FROM sms_updates JOIN sms_providers ON sms_updates.sms_provider_id=sms_providers.sms_provider_id WHERE school_id=? AND sms_on=1", $_SESSION["id"]); 
        
        // creates the emails from the texts
        foreach($texts as $text)
        {
            $emails[] = array("email_email" => $text["sms_number"] . $text["sms_provider_email"]); 
        }
        
        // gets the name of the required fields
        $team = query("SELECT * FROM teams WHERE team_id=?", $_POST["team"]); 
        $teamname = $team[0]["team_name1"] . "-" . $team[0]["team_name2"]; 
        $tournamentname=query("SELECT tournament_name FROM tournaments WHERE tournament_id=?", $_POST["tournament"]); 
        
        // sets the round
        $_POST["round"] = $GLOBALS["OUTROUNDS"][$_POST["round"]]; 
        
        // sets the result
        if($_POST["result"] == 1)
        {
            $result = "WON";
        }
        else
        {
            $result = "LOST";
        }
        
        // creates the message
        $message = $tournamentname[0]["tournament_name"] . " - Round " . $_POST["round"] . "\n" .$teamname. " " . $result . " v. " . $_POST["opp"] . " ON " . $_POST["2nr"]; 
        
        // creates headers
        $headers = "From: no-reply@debatelockers.com\n"; 
        
        // sends to all of the email recipients
        foreach($emails as $email)
        {
            mail($email["email_email"], "DebateLocker Bot", $message, $headers);
        }
        

        // redirect
        redirect("quick.php"); 
    }
    else
    {
        redirect("/");
    }

?>

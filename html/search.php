<?php

    // configuration
    require("../includes/config.php"); 
    
    // sets the input fields
    $fields = array("Team"=>0, "Tournament"=> 0, "Judge"=>0, "Opponent"=>0); 
    
    // if the form was submitted
    if($_SERVER["REQUEST_METHOD"] == "POST")
    { 
        // creates a variable of all posted items
        $posted = array();

        // saves the information from post into the posted variable and deletes from $_POST
        foreach($fields as $field => $value)
        {   
            $posted[$field] = array(); 
            
            // all of the items in the post
            for($i = 0; $i < 5; $i++)
            {
                // key to access $_POST
                $key = $field . $i; 
                
                // if it isn't empty, store into $posted
                if(!empty($_POST[$key]))
                {
                    $posted[$field][] = strtoupper($_POST[$key]); 
                }
                
                unset($_POST[$key]); 
            }
        }
        
        $team_ids = array(); 

        // parses team names
        foreach($posted["Team"] as $entered)
        {
            $tmp_team = explode("-", $entered);
            
            // if too many teams
            if(isset($tmp_team[2]))
            {
                apologize("Sorry, your team format is incorrect."); 
            }
            // else if there's more than one word
            else if(isset($tmp_team[1]))
            {
                if(strcmp($tmp_team[0], $tmp_team[1]) > 0)
                {
                    $tmp = $tmp_team[0]; 
                    $tmp_team[0] = $tmp_team[1]; 
                    $tmp_team[1] = $tmp;
                }

                // get the id's of the team
                $team_id = query("SELECT * FROM teams WHERE school_id=? AND team_name1=? AND team_name2=?", $_SESSION["id"], $tmp_team[0], $tmp_team[1]); 
                
                if(isset($team_id[0]))
                {
                    $team_ids[] = $team_id[0]["team_id"]; 
                }
            }
            // else if there's only one word
            else
            {
                $team_id = query("SELECT * FROM teams WHERE school_id=? AND (team_name1=? OR team_name2=?)", $_SESSION["id"], $tmp_team[0], $tmp_team[0]);
                
                foreach($team_id as $id)
                {
                    $team_ids[] = $id["team_id"]; 
                } 
            }
        }
        
        // if posted isn't empty but id's are must have found no results
        if(!empty($posted["Team"]) && empty($team_ids))
        {
            apologize("Search query found no results."); 
        }
        
        // remove from posted
        unset($posted["Team"]); 
        
        $tournament_ids = array(); 
        
        // parses tournament names
        foreach($posted["Tournament"] as $entered)
        {
            $tmp_tournament = explode(" ", $entered); 
            
            // if there's more than one space, apologize   
            if(isset($tmp_tournament[2]))
            {
                apologize("Sorry, your tournament format is incorrect (at most one space)."); 
            }
            // else if there's a date after the tournamnet
            else if(isset($tmp_tournament[1]))
            {
                if($tmp_tournament[1] > date("Y") + 1 || $tmp_tournament[1] < 2012)
                {
                    apologize("Tournament format incorrect. [tournament name] [tournament_year (4 digits)]."); 
                }
            
                $tournament_id = query("SELECT * FROM tournaments WHERE tournament_name=? AND tournament_year=?", $tmp_tournament[0], $tmp_tournament[1]); 
                
                if(isset($tournament_id[0]))
                {
                    $tournament_ids[] = $tournament_id[0]["tournament_id"];                 
                }
            }
            // else it must just be the tournament name
            else
            {
                $tournament_id = query("SELECT * FROM tournaments WHERE (tournament_name=? OR tournament_year=?)", $tmp_tournament[0], $tmp_tournament[0]); 
                
                foreach($tournament_id as $id)
                {
                    $tournament_ids[] = $id["tournament_id"]; 
                }
            }
        }

        // if posted isn't empty but id's are must have found no results
        if(!empty($posted["Tournament"]) && empty($tournament_ids))
        {
            apologize("Search query found no results."); 
        }

        unset($posted["Tournament"]); 
        
        $judge_ids = array(); 
        
        // parses judge names
        foreach($posted["Judge"] as &$entered)
        {
            $tmp_judge = explode(" ", $entered); 
            
            // if more than two words
            if(isset($tmp_judge[2]))
            {
                apologize("Sorry, your judge format is incorrect (at most one space)."); 
            }
            // else get the id's of the judge on first name last name
            else if(isset($tmp_judge[1]))
            {            
                $judge_id = query("SELECT * FROM judges WHERE judge_first=? AND judge_last=?", $tmp_judge[0], $tmp_judge[1]); 
                
                if(isset($judge_id[0]))
                {
                    $judge_ids[] = $judge_id[0]["judge_id"]; 
                }
            }
            // else get the id's of the judge on either name
            else
            {
                $judge_id = query("SELECT * FROM judges WHERE judge_first=? OR judge_last=?", $tmp_judge[0], $tmp_judge[0]);
                
                foreach($judge_id as $id)
                {
                    $judge_ids[] = $id["judge_id"]; 
                } 
            }
        }

        // if no judges were found but were posted, then no results are found
        if(!empty($posted["Judge"]) && empty($judge_ids))
        {
            apologize("Search query found no results."); 
        }
        
        unset($posted["Judge"]); 
        
        // string to query the database
        $string = "SELECT reports.report_result, reports.report_side, reports.report_opp, reports.report_id, reports.judge1_id, judges.judge_last, tournaments.tournament_name, reports.round_num, teams.team_name1, teams.team_name2, tournaments.tournament_year FROM reports JOIN (teams, tournaments, judges) ON (reports.team_id=teams.team_id AND reports.tournament_id=tournaments.tournament_id AND reports.judge_id=judges.judge_id) WHERE reports.school_id='" . $_SESSION["id"]. "' AND ("; 
        
        // order to query by
        $order = "ORDER BY tournaments.tournament_year, tournaments.tournament_name, teams.team_name1, reports.round_num";
        
        // if side was submitted put in, else leave empty
        if(!empty($_POST["side"]))
        {
            $columns = "reports.report_side='" . $_POST["side"] . "') AND (";
        }
        else
        {
            $columns = ""; 
        }
        
        unset($_POST["side"]); 
        
        // if result was submitted put in, else leave empty
        if(!empty($_POST["result"]))
        {
            $columns .= "reports.report_result='" . $_POST["result"] . "') AND (";
        }
        
        unset($_POST["result"]); 
    
        // if there are teams - then add all of the teams in
        if(isset($team_ids[0]))
        {         
            end($team_ids);
            $last_key = key($team_ids); 
        
            foreach($team_ids as $key => $id)
            {
                if($key == $last_key)
                {
                    $columns .= "reports.team_id='" . $id . "'"; 
                }
                else
                {
                    $columns .= "reports.team_id='" . $id . "' OR ";
                } 
            }
    
            $columns .= ") AND (";
        }
        
        // if there are judges, then add all of the judges in
        if(isset($judge_ids[0]))
        {
            end($judge_ids);
            $last_key = key($judge_ids); 

            // for each judge id
            foreach($judge_ids as $key => $id)
            {
                if($key == $last_key)
                {
                    // check judge0
                    $columns .= "reports.judge_id='" . $id . "' OR "; 
                    
                    // check judge1 through judge3
                    for($i = 1; $i < 4; $i++)
                    {
                        $columns .="reports.judge" . $i . "_id='" . $id . "' OR "; 
                    }
                    
                    // check judge4 and don't add or at the end
                    $columns .="reports.judge4_id='" . $id . "'"; 
                }
                // else check all the judges and add or at the end
                else
                {
                    $columns .= "reports.judge_id='" . $id . "' OR ";
                    
                    for($i = 1; $i < 5; $i++)
                    {
                        $columns .="reports.judge" . $i . "_id='" . $id . "' OR "; 
                    }
                } 
            }        
    
            // add seperator to column
            $columns .= ") AND (";
        }
 
        // if there were tournaments, then add all of the tournaments in
        if(isset($tournament_ids[0]))
        {
            end($tournament_ids);
            $last_key = key($tournament_ids); 

            // for all tournament id's add into columns
            foreach($tournament_ids as $key => $id)
            {
                if($key == $last_key)
                {
                    $columns .= "reports.tournament_id='" . $id . "'"; 
                }
                else
                {
                    $columns .= "reports.tournament_id='" . $id . "' OR ";
                } 
            }         
    
            // add seperator
            $columns .= ") AND (";
        }

        // if still more in $_POST, then must be round
        if(!empty($_POST))
        {
            end($_POST);
            $last_key = key($_POST); 
            
            // add the $_POST into the columns
            foreach($_POST as $key => $round)
            {
                if($key == $last_key)
                {
                    $columns .= "reports.round_num='" . $round . "'"; 
                }
                else
                {
                    $columns .= "reports.round_num='" . $round . "' OR "; 
                }
            }

            $columns .= ") AND (";
        }
        
        // if there are opponents entered
        if(!empty($posted["Opponent"]))
        {
            end($posted["Opponent"]); 
            $last_key = key($posted["Opponent"]); 
            
            // add opponents into columns
            foreach($posted["Opponent"] as $key => $opp)
            {
                if($key == $last_key)
                {
                    $columns .= "reports.report_opp='" . $opp . "'"; 
                }
                else
                {
                    $columns .= "reports.report_opp='" . $opp . "' OR "; 
                }
            }
        }

        // string is the column closed plus order
        $string .= $columns . ") " . $order; 
        // removes extra empty spaces from the string
        $string = str_replace("AND () ", "", $string); 
        // queries the database 
        $rounds = query($string);
        // makes the round displayable 
        $rounds = make_displayable($rounds, "single"); 
        // render
        render("show_reports.php", array("title"=>"Searched", "type"=>"Searched", "rounds"=>$rounds)); 
    }
    
    // else render the form
    else
    {
        render("search_form.php", array("title"=>"Search", "fields" => $fields)); 
    }
?>

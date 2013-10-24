<?php

    /***********************************************************************
     * functions.php
     *
     * Willy Xiao
     * Final Project
     *
     * Helper functions.
     **********************************************************************/

    require_once("constants.php"); 
    
    /**
     * Apologizes to user with message.
     */
    function apologize($message)
    {
        render("apology.php", array("message" => $message));
        exit;
    }

    /*
     * Checks if it's a valid email address
     * List 2 from: http://www.linuxjournal.com/article/9585
    */    
    function check_email_address($email) {
        // First, we check that there's one @ symbol, and that the lengths are right
        if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
            // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
            return false;
        }

        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for ($i = 0; $i < sizeof($local_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
                return false;
            }
        }
        if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2) {
                return false; // Not enough parts to domain
            }
            for ($i = 0; $i < sizeof($domain_array); $i++) {
                if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Facilitates debugging by dumping contents of variable
     * to browser.
     */
    function dump($variable)
    {
        require("../templates/dump.php");
        exit;
    }

    /**
    * Inserts a key into an array before an original key
    * http://stackoverflow.com/questions/2149437/how-to-add-an-array-value-to-the-middle-of-an-associative-array
    */
    
    function InsertBeforeKey($originalArray, $originalKey, $insertKey, $insertValue) 
    {

        $newArray = array();
        $inserted = false;

        foreach( $originalArray as $key => $value ) {

            if( !$inserted && $key === $originalKey ) {
                $newArray[ $insertKey ] = $insertValue;
                $inserted = true;
            }

            $newArray[ $key ] = $value;

        }

        return $newArray;

    }

    /**
     * Gets the judges from the format of a string firstname1 lastname1; firstname2 lastname2; ...
     */
     function get_judges($string)
     {
        // gets judge names seperated by a semicolon
        $judge_names = explode("; ", $string); 
        
        // if there are more than five judge names, apologize
        if(count($judge_names) > 5)
        {
            apologize("Judge format incorrect. Max 5 judges"); 
        }

        // array of judges
        $judges = array(); 

        // iterator 
        $i = 0; 
        
        // iterates over all of the judge names
        foreach($judge_names as $judge_name)
        {
            // if there is more than one space in any judge name, apologize
            if(substr_count($judge_name, " ") > 1)
            {
                apologize("Judge format incorrect. No extra spaces");
            }
            
            // saves the first and last names into the judges array
            $judges[$i] = explode(" ", $judge_name); 
            
            // iterates the iterator
            $i++; 
        }
        
        // checks if all of the judges are unique
        foreach($judges as $key => $judge)
        {
            foreach($judges as $test_key => $tester)
            {
                if($key != $test_key && ($judge[0] == $tester[0] && $judge[1] == $tester[1]))
                {
                    apologize("Only enter each judge once!"); 
                }
            }
        }
        
        // checks that some judges are entered
        if(empty($judges[0][0]) || $judges[0][0] == ";")
        {
            apologize("Judge format incorrect. Empty judges."); 
        }
        
        // returns judges
        return $judges; 
     }

    /**
     * Gets judge id's from an array of judge first names and last names
     */
    
    function get_judge_ids($judges)
    {
        // iterator
        $i = 0; 
        
        foreach($judges as $judge)
        {
            if(!empty($judge[0]))
            {
                // checks if judge is in the database
                $_judge = query("SELECT * FROM judges WHERE judge_first = ? AND judge_last = ?", $judge[0], $judge[1]); 

                // if the judge isn't already in the database, add the judge in
                if(!isset($_judge[0]))
                {
                    query("INSERT INTO judges (judge_first, judge_last) VALUES (?, ?)", $judge[0], $judge[1]); 
                    
                    // gets the judge id again
                    $_judge = query("SELECT judge_id FROM judges WHERE judge_first = ? AND judge_last = ?", $judge[0], $judge[1]);
                }
                
                // gets the judge id's
                $judge_ids[$i] = $_judge[0]["judge_id"]; 
                
                // iterates iterator 
                $i++; 
            }
            else
            {
                break; 
            }
        }
        
        // nulls the rest   
        for($i; $i < 5; $i++)
        {
            $judge_ids[$i] = NULL; 
        }
        
        return $judge_ids; 
    }
     
    /**
     * Logs out current user, if any.  Based on Example #1 at
     * http://us.php.net/manual/en/function.session-destroy.php.
     */
    function logout()
    {
        // unset any session variables
        $_SESSION = array();

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();
    }

    /**
     * Makes rounds displayable. The input must be an sql response
     */
    function make_displayable($rounds, $judge_option)
    {
        // changes the information in the round
        foreach($rounds as &$round)
        { 
        
            // makes the team names
            $team_name = $round["team_name1"] . "-" . $round["team_name2"];
            $round = InsertBeforeKey($round, "team_name1", "team", $team_name); 
            unset($round["team_name1"]); 
            unset($round["team_name2"]); 
            
            // makes the tournament name
            $tournament_name = $round["tournament_name"] . " " . $round["tournament_year"]; 
            $round = InsertBeforeKey($round, "tournament_name", "tournament", $tournament_name); 
            unset($round["tournament_name"]); 
            unset($round["tournament_year"]); 
            
            // round number to name of round
            if(isset($GLOBALS["OUTROUNDS"][$round["round_num"]]))
            {    
                $round["round_num"] = $GLOBALS["OUTROUNDS"][$round["round_num"]]; 
            }

            // changes the side from numeric to characters
            if($round["report_side"] == 1)
            {
                $round["report_side"] = "AFF";         
            }
            else 
            {
                $round["report_side"] = "NEG"; 
            }
            
            // changes the result from numeric to characters
            if($round["report_result"] == 1)
            {
                $round["report_result"] = "W"; 
            }
            else
            {
                $round["report_result"] = "L"; 
            }        
        
            // if asking for a single judge
            if($judge_option == "single")
            {
                // if more than one judge, display MULTIPLE
                if(!empty($round["judge1_id"]))
                {
                    $round["judge_last"] = "[MULTIPLE]"; 
                }
            }
            // if asking for multiple judges
            else if($judge_option == "multiple")
            {
                $judge_names = ""; 
                $exists = true; 
            
                // for all of the judges
                for($i = 0; $i < 5; $i++)
                {
                    // creates the key
                    if($i > 0)
                    {
                        $key = "judge" . $i . "_id"; 
                    }
                    else
                    {
                        $key = "judge_id";
                    }
                    
                    // if the key exists, get the name from the database
                    if(!empty($round[$key]) && $exists)
                    {
                        $judge_name = query("SELECT judge_first, judge_last FROM judges WHERE judge_id=?", $round[$key]); 
                        $judge_name = $judge_name[0];  
                        
                        // makes the string of all the judge names, no comma for first one
                        if($i > 0)
                        {
                            $judge_names .= ", " . $judge_name["judge_first"] . " " . $judge_name["judge_last"]; 
                        }
                        else
                        {
                            $judge_names .= $judge_name["judge_first"] . " " . $judge_name["judge_last"];
                        }
                    }
                    else
                    {
                        // keys no longer exist
                        $exists = false; 
                    }

                    // insert the judge names into the array right before the id
                    $round = InsertBeforeKey($round, $key, "judge_names", $judge_names);                      

                    // unsets the round key
                    unset($round[$key]);                      
                }
            }        
        }

        return $rounds;   
    }
    
    /**
     * Prints all of the rounds as option values
     */
    function print_rounds($type)
    {           
        if($type === "select")
        {            
            // prints all of the extra rounds
            foreach($GLOBALS["OUTROUNDS"] as $value => $round)
            {
                print("<option value=\"" . $value . "\">" . $round . "</option>"); 
            }
        }
        else if($type === "checkbox")
        {
            // iterator
            $i = 0; 
            
            // print the first check_group
            print("<div class=\"check_group1\">");   
                      
            // all of the rounds
            foreach($GLOBALS["OUTROUNDS"] as $round => $key)
            {
                // if the prelims are over, make a new checkgroup
                if($i == 8)
                {
                    print("</div><div class=\"check_group2\">");
                }
                            
                // print the checkboxes and labels
                print("<div class=\"checkbox\">"); 
                print("<input type=\"checkbox\" id=\"check_" . $round . "\" name=\"round" . $round . "\" value=\"" . $round . "\" />");
                print("<label class=\"checkbox_label\" for=\"check_" . $round . "\" >" . $key . "</label></div>");  
                            
                // iterate
                $i++;
           }
           
           print("</div>"); 
        }
    }

    /**
     * Executes SQL statement, possibly with parameters, returning
     * an array of all rows in result set or false on (non-fatal) error.
     */
    function query(/* $sql [, ... ] */)
    {
        // SQL statement
        $sql = func_get_arg(0);

        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);

        // try to connect to database
        static $handle;
        if (!isset($handle))
        {
            try
            {
                // connect to database
                $handle = new PDO("mysql:dbname=" . DATABASE . ";host=" . SERVER, USERNAME, PASSWORD);

                // ensure that PDO::prepare returns false when passed invalid SQL
                $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            }
            catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
                exit;
            }
        }

        // prepare SQL statement
        $statement = $handle->prepare($sql);
        if ($statement === false)
        {
            $error_info = $handle->errorInfo(); 
            
            // trigger (big, orange) error
            trigger_error($error_info[2], E_USER_ERROR);
            exit;
        }

        // execute SQL statement
        $results = $statement->execute($parameters);

        // return result set's rows, if any
        if ($results !== false)
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    /**
     * Redirects user to destination, which can be
     * a URL or a relative path on the local host.
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     */
    function redirect($destination)
    {
        // handle URL
        if (preg_match("/^https?:\/\//", $destination))
        {
            header("Location: " . $destination);
        }

        // handle absolute path
        else if (preg_match("/^\//", $destination))
        {
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            header("Location: $protocol://$host$destination");
        }

        // handle relative path
        else
        {
            // adapted from http://www.php.net/header
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            header("Location: $protocol://$host$path/$destination");
        }

        // exit immediately since we're redirecting anyway
        exit;
    }

    /**
     * Renders template, passing in values.
     */
    function render($template, $values = array())
    {
        // if template exists, render it
        if (file_exists("../templates/$template"))
        {
            // extract variables into local scope
            extract($values);

            // render header
            require("../templates/header.php");

            // render template
            require("../templates/$template");

            // render footer
            require("../templates/footer.php");
        }

        // else err
        else
        {
            trigger_error("Invalid template: $template", E_USER_ERROR);
        }
    }

?>

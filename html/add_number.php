<?php
    // configuration
    require("../includes/config.php"); 
    
    // if form was submitted
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // if the verification code wasn't submitted
        if(!isset($_POST["code"]))
        {
            // checks if any fields are empty
            if(empty($_POST["number"]) || empty($_POST["provider"]))
            {
                apologize("Enter both fields."); 
            }
            
            // removes all common characters from the number
            $search = array(0=>"(", 1=>")", 2=>"-"); 
            
            $_POST["number"] = str_replace($search, "", $_POST["number"]); 
            
            // checks to make sure it's a valid number
            // by length
            if(strlen($_POST["number"]) != 10)
            {
                apologize("Invalid phone number length."); 
            }
            
            // by type of characters
            for($i = 0; $i < 10; $i++)
            {
                if(!is_numeric($_POST["number"][$i]))
                {
                    apologize("Invalide phone number type."); 
                }
            }
            
            // checks if the number already exists
            $numbers = query("SELECT * FROM sms_updates WHERE school_id=? AND sms_number=?", $_SESSION["id"], $_POST["number"]); 
            
            if(!empty($numbers[0]))
            {
                apologize("Number already exists."); 
            }
            
            // creates confirmation code
            $letters = chr(rand(ord('A'), ord('Z'))) . chr(rand(ord('A'), ord('Z'))); 
            $code = $letters . rand(10, 99) . rand(10, 99) . rand(10, 99);
            
            // gets the email address
            $location = query("SELECT sms_provider_email FROM sms_providers WHERE sms_provider_id=?", $_POST["provider"]); 
            
            // sends confirmation code to the user
            $email = $_POST["number"] . $location[0]["sms_provider_email"]; 
            $message = "Verification Code: " . $code; 
            $headers = "From: confirm@debatelockers.com\n"; 
            mail($email, "DebateLocker Bot", $message, $headers); 
            
            // saves information in global array
            $_SESSION["code"] = array("code"=>$code, "number"=>$_POST["number"], "provider"=>$_POST["provider"]); 
            
            // renders confirmation code
            render("confirm_form.php", array("title" => "Confirm", "type"=>"sms")); 
        }
        else
        {
            // if code is correct
            if($_SESSION["code"]["code"] == $_POST["code"])
            {
                // insert into database
                query("INSERT INTO sms_updates (school_id, sms_number, sms_provider_id) VALUES (?, ?, ?)", $_SESSION["id"], $_SESSION["code"]["number"], $_SESSION["code"]["provider"]); 
                
                // unset code
                unset($_SESSION["code"]); 
            }
            else
            {
                // unset code
                unset($_SESSION["code"]); 

                // apologize, code is wrong
                apologize("Sorry, incorrect code."); 
            }
            
            // redirects to manage updates
            redirect("updates.php"); 
        }
    }
    
    // else go to homepage
    else
    {
        redirect("/"); 
    }

?>

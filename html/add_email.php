<?php

    // configuration
    require("../includes/config.php"); 
    
    // if form was submitted
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // checks if anything was submitted
        if(empty($_POST["email"]))
        {
            apologize("Enter email please."); 
        }
        
        // checks if it's a legit email adress
        if(!check_email_address($_POST["email"]))
        {
            apologize("Illegit email address."); 
        }        

        // makes the string lower case
        $_POST["email"] = strtolower($_POST["email"]); 
        
        // checks if the email already exists
        $emails = query("SELECT * FROM email_updates WHERE school_id=?", $_SESSION["id"]); 
        
        foreach($emails as $email)
        {
            if($_POST["email"] == $email["email_email"])
            {
                apologize("Email already exists."); 
            }
        }
        
        // insert into database
        query("INSERT INTO email_updates (school_id, email_email) VALUES (?, ?)", $_SESSION["id"], $_POST["email"]); 

        redirect("updates.php"); 
    }
    
    // else go to homepage
    else
    {
        redirect("/"); 
    }

?>

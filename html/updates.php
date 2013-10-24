<?php

    // configuration
    require("../includes/config.php");    

    // gets the emails from the database
    $emails = query("SELECT * FROM email_updates WHERE school_id=? ORDER BY email_email", $_SESSION["id"]); 
    $numbers = query("SELECT * FROM sms_updates WHERE school_id=? ORDER BY sms_number", $_SESSION["id"]); 
    $providers = query("SELECT * FROM sms_providers ORDER BY sms_provider_name"); 
        
    // render the form
    render("updates_form.php", array("title" => "Updates", "emails"=>$emails, "numbers"=>$numbers, "providers" => $providers)); 
?>

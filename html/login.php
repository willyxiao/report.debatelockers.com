<?

    //configuration
    require("../includes/config.php");
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["school"]))
        {
            apologize("You must provide a school.");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide a password.");
        }

        // makes the name lowercase
        $school = strtolower($_POST["school"]);

        // query database for user
        $rows = query("SELECT * FROM users WHERE school_name = ?", $_POST["school"]);

        // if we found user, check password
        if (count($rows) == 1)
        {
            // first (and only) row
            $row = $rows[0];

            // compare hash of user's input against hash that's in database
            if (crypt($_POST["password"], $row["school_hash"]) == $row["school_hash"])
            {
                // remember that user's now logged in by storing user's ID in session
                $_SESSION["id"] = $row["school_id"];
                
                // remember the name of the school
                $_SESSION["school_name"] = $row["school_name"]; 

                // redirect to logged-in page
                redirect("/");
            }
        }

        // else apologize
        apologize("Invalid username and/or password.");
    }
    else
    {
        render("login_form.php"); 
    }
?>

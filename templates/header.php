<!DOCTYPE html>

<html>

    <head>

        <link href="css/what.css" rel="stylesheet"/>
        <link rel="icon" href="images/favicon.ico"/>
        <?php if (isset($title)): ?>
            <title>Report: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>Report</title>
        <?php endif ?>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="js/scripts.js"></script>

    </head>

    <body>

        <div id="head">
            <div id="username"><?php if(isset($_SESSION["school_name"])) {print("Logged in as ".$_SESSION["school_name"]);} ?></div>
        </div>
        <?php
            if(!preg_match("{(?:login|logout|register)\.php$}", $_SERVER["PHP_SELF"]))
            {
                if(isset($_SESSION["id"]))
                {
                    require("../templates/sidebar.php"); 
                }
            }
        ?>
        <div id="mid">
            <div id="content">

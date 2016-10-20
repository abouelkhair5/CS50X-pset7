<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["username"]))
        {
            apologize("You must provide your username.");
        }
        else if (!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)) {
            apologize("Invalid email address.");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide your password.");
        }
        else if ($_POST["password"] != $_POST["confirmation"])
        {
            apologize("The two passwords must be the same.");
        }
        
        $rows = CS50::query("INSERT IGNORE INTO users (username, email, hash, cash) VALUES(?, ?, ?, 10000.0000)", $_POST["username"], $_POST["email"], password_hash($_POST["password"], PASSWORD_DEFAULT));
        
        if($rows == 0){
            $rows = CS50::query("SELECT * FROM users WHERE username = ?", $_POST["username"]);
            if(!empty($rows)){
                apologize("Username already exists.");
            }
            $rows = CS50::query("SELECT * FROM users WHERE email = ?", $_POST["email"]);
            if(!empty($rows)){
                apologize("The account with this email address already exists.");
            }
            apologize("Something went wrong. We're working on it!");
        }
        
        $rows = CS50::query("SELECT LAST_INSERT_ID() AS id");
        $id = $rows[0]["id"];
        // remember that user's now logged in by storing user's ID in session
        $_SESSION["id"] = $id;

        // redirect to portfolio
        redirect("/index.php");
    }

?>
<?php
    
    require("../includes/config.php");
    
    if($_SERVER["REQUEST_METHOD"] == "GET") 
    {
        render("change.php", ["title" => "Change password"]);    
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if(empty($_POST["old"]))
        {
            apologize("You have to provide your old password.");
        }
        
        $user = CS50 :: query("SELECT * FROM users WHERE id = {$_SESSION['id']}");
        
        if(!password_verify($_POST["old"], $user[0]["hash"]))
        {
            apologize("The password you provided is incorrect.");
        }
        
        if(empty($_POST["new"]))
        {
            apologize("You have to provide the new password.");
        }
        else if (empty($_POST["confirm"]))
        {
            apologize("You have to confirm your new password.");
        }
        
        else if ($_POST["new"] !== $_POST["confirm"] )
        {
            apologize("The two passwords do not match.");
        }
        
        CS50 :: query("UPDATE users SET hash = ?", password_hash($_POST["new"], PASSWORD_DEFAULT));
        redirect("change_success.php");
        
    }
?>
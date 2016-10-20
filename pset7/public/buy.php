<?php
    require("../includes/config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "GET"){
        render("buy_form.php", ['title' => "Buy"]);
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        // Checking a stock symbol was provided by the user
        if(empty($_POST["symbol"])){
            apologize("You must specify a stock to buy.");
        }
        
        // Checking a number of shares was given by the user
        if(empty($_POST["shares"])){
            apologize("You must specify a number of shares.");
        }
        
        // Checking the a stock with the given symbol exists
        $stock = lookup($_POST["symbol"]);
        if($stock == false){
            apologize("Symbol not found.");
        }
        
        // Checking the provided 
        if(!preg_match("/^\d+$/", $_POST["shares"])){
            apologize("Invalid number of shares.");
        }
        
        $total_price = $stock["price"] * $_POST["shares"];
        
        $user = CS50 :: query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);
        if($total_price > $user[0]["cash"]){
            apologize("You can't afford that");
        }
        
        CS50 :: query("INSERT INTO shares (user_id, symbol, shares) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)",$user[0]["id"],$stock["symbol"], $_POST["shares"]);
        CS50 :: query("UPDATE users SET cash = cash - ? WHERE id = ?", $total_price, $user[0]["id"]);
        CS50 :: query("INSERT INTO history (user_id, transaction, symbol, price, shares) VALUES(?, false, ?, ?, ?)", $user[0]["id"], $stock["symbol"], $stock["price"], $_POST["shares"]);
        redirect("index.php");
    }
?>
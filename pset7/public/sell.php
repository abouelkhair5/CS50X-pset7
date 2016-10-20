<?php 
    
    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $rows = CS50 :: query("SELECT * FROM shares WHERE user_id = ?", $_SESSION["id"]);
        if(empty($rows)){
            apologize("Nothing to sell");
        }
    
        $symbols = [];
        foreach ($rows as $row)
        {
            $stock = lookup($row["symbol"]);
            if ($stock !== false)
            {
                $symbols[] = $row["symbol"];
            }
        }
        // else render form
        render("sell_form.php", ["title" => "Sell", "symbols" => $symbols]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $share = CS50 :: query("SELECT * FROM shares WHERE user_id = ? AND symbol = ?", $_SESSION['id'], $_POST['symbol']);
        $quote = lookup($_POST['symbol']);
        $cash_change = $quote['price'] * $share[0]["shares"];
        CS50 :: query("INSERT INTO history (user_id, transaction, symbol, price, shares) VALUES(?, true, ?, ?, ?)", $_SESSION['id'], $quote["symbol"], $quote["price"], $share[0]["shares"]);
        CS50 :: query("UPDATE users SET cash = cash + ? WHERE id = ?", $cash_change, $_SESSION['id']);
        CS50 :: query("DELETE FROM shares WHERE user_id = ? AND symbol = ?", $_SESSION['id'], $quote['symbol']);
        redirect("index.php");
    }
?>
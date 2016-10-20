<?php
    
    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("quote_form.php", ["title" => "Quote"]);
    }
    
    // if user reacheed page via POST (as by inquiring about a stock)
    else if($_SERVER["REQUEST_METHOD"] == "POST")
    {
            $stock = lookup($_POST["symbol"]);
            if($stock == false)
            {
                apologize("The stock with this symbol doesn't exist.");
            }
            $name = $stock["name"];
            $symbol = $stock["symbol"];
            $price = number_format($stock["price"], 2, '.', '');
            render("quote_return.php", ["title" => "Quote", "name" => $name, "price" => $price, "symbol" => $symbol]);
    }
    
    
?>
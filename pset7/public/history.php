<?php
    require("../includes/config.php");
    $user_data = CS50 :: query("SELECT * FROM history WHERE user_id = {$_SESSION['id']}");
    render("history.php", ["title" => "history", "user_data" => $user_data]);
?>
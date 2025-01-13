<?php

include "../connect.php";

$email       = filterRequest("email");
$password    = sha1($_POST["password"]);

getData("account", "`email` = ? AND `password` = ? And `approve` = 1 ", array($email, $password));

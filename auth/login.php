<?php

include "../connect.php";

$email       = filterRequest("email");
$password    = sha1($_POST["password"]);


$stmt = $con->prepare("SELECT * FROM `account` WHERE `email` = ? AND `password` = ? And `approve` = 1 ");
$stmt->execute(array($email, $password));
$count = $stmt->rowCount();

result($count);

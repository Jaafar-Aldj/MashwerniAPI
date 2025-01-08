<?php

include "../connect.php";

$email       = filterRequest("email");
$password    = sha1("password");


$stmt = $con->prepare("SELECT * FROM `account` WHERE `email` = ? AND `password` = ?");
$stmt->execute(array($email, $password));
$count = $stmt->rowCount();

result($count);

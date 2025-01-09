<?php

include "../connect.php";

$email       = filterRequest("email");
$verifycode  = rand(100000, 999999);

$stmt = $con->prepare("SELECT * FROM `account` WHERE `email` = ? And `approve` = 1 ");
$stmt->execute(array($email));
$count = $stmt->rowCount();

result($count);
if ($count > 0) {
    $data = array("verifycode" => $verifycode);
    updateData("account", $data, "`email` = '$email'", false);
    sendMail($email, "Mashwerni Reset Password", "Your VerifyCode is : $verifycode");
}

<?php
include "../connect.php";

$email       = filterRequest('email');
$verifycode  = filterRequest('verifycode');

$stmt = $con->prepare("SELECT * FROM `account` WHERE `email` = :email AND `verifycode` = :verifycode");
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->bindParam(':verifycode', $verifycode, PDO::PARAM_INT);
$stmt->execute();
$count =  $stmt->rowCount();

if ($count > 0) {
    $data = array("approve" => 1);
    updateData("account", $data, "`email` = '$email'");
} else {
    printFailure("VerifyCode isn't correct");
}

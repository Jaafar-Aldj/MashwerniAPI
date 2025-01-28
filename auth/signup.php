<?php

include "../connect.php";

$email       = filterRequest("email");
$password    = sha1($_POST["password"]);
$phone       = filterRequest("phone");
$verifycode  = rand(100000, 999999);


$stmt = $con->prepare("SELECT * FROM `account` WHERE `email` = ? OR `phone` = ?");
$stmt->execute(array($email, $phone));
$count = $stmt->rowCount();

if ($count > 0) {
    printFailure("Phone or email is already exist");
} else {
    $data = array(
        "email"       => $email,
        "password"    => $password,
        "phone"       => $phone,
        "verifycode"  => $verifycode,
    );
    insertData("account", $data, false);
    sendMail($email, "Mashwerni Verification Code", "Your VerifyCode is : $verifycode");
    getData("account", "`email` = ? AND `password` = ?", array($email, $password));
}

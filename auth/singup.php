<?php

include "../connect.php";

$email       = filterRequest("email");
$password    = sha1("password");
$phone       = filterRequest("phone");
$verifycode  = rand(100000, 999999);


$stmt = $con->prepare("SELECT * FROM `account` WHERE `email` = ? AND `phone` = ?");
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
    insertData("account", $data);
    sendMail($email, "Mashwerni Verify Code", "Your verify code is : $verifycode");
}
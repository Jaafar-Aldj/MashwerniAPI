<?php

include "../connect.php";


$email       = filterRequest("email");
$verifycode  = rand(100000, 999999);
$data = array(
    "verifycode" => $verifycode,
);

updateData('account', $data, "email = '$email'");

sendMail($email, "Mashwerni Verification Code", "Your VerifyCode is : $verifycode");

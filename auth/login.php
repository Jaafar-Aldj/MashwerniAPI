<?php

include "../connect.php";

$email       = filterRequest("email");
$password    = sha1($_POST["password"]);

$alldata = array();

$account = getData("account", "`email` = ? AND `password` = ?", array($email, $password), false);
if ($account == 0) {
    $alldata['status'] = 'failure';
} else {
    $alldata['status'] = 'success';
    $alldata['data'] = $account;
    if ($account['is_manager'] == 1) {
        $manager = getData("manager", "account_id = ?", array($account['ID']), false);
        $alldata['manager'] = $manager;
    } else {
        $user = getData("user", "account_id = ?", array($account['ID']), false);
        $alldata['user'] = $user;
    }
}

echo json_encode($alldata);

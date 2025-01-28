<?php

include '../connect.php';

$account_id   = filterRequest('account_id');
$company_name = filterRequest('company_name');
$company_name_ar = filterRequest('company_name_ar');

$stmt = $con->prepare("SELECT * FROM `account` WHERE `ID` = ?");
$stmt->execute(array($account_id));
$account = $stmt->fetch(PDO::FETCH_ASSOC);
$is_manager = $account['is_manager'];
$count_acc = $stmt->rowCount();

$stmt = $con->prepare("SELECT * FROM `manager` WHERE `account_id` = ?");
$stmt->execute(array($account_id));
$count_manager = $stmt->rowCount();


if ($count_acc > 0 && $count_manager == 0 && $is_manager == 1) {
    $stmt = $con->prepare("SELECT * FROM `user` WHERE `account_id` = ?");
    $stmt->execute(array($account_id));
    $count_user = $stmt->rowCount();
    if ($count_user > 0) {
        deleteData('user', "`account_id` = $account_id", false);
    }
    $data = array(
        "account_id"   => $account_id,
        "company_name" => $company_name,
        "company_name_ar" => $company_name_ar,
    );
    insertData("manager", $data);
} elseif ($count_acc == 0) {
    printFailure("Account not existed");
} elseif ($is_manager == 0) {
    printFailure("You can't be a manager");
} else {
    printFailure("Manager had already registered");
}

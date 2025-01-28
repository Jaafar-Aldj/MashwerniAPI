<?php

include "../connect.php";

$accountID       = filterRequest("account_id");

$alldata = array();

$account = getData("account", "`ID` = ?", array($accountID), false);
if ($account == 0) {
    $alldata['status'] = 'failure';
} else {
    $alldata['status'] = 'success';
    $alldata['data'] = $account;
    if ($account['is_manager'] == 1) {
        $manager = getData("manager", "account_id = ?", array($account['ID']), false);
        $alldata['manager'] = $manager;
    }
}

echo json_encode($alldata);

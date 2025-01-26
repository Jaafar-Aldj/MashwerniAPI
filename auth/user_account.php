<?php

include '../connect.php';

$account_id          = filterRequest('account_id');
$f_name              = filterRequest('f_name');
$f_name              = filterRequest('f_name_ar');
$l_name              = filterRequest('l_name');
$l_name              = filterRequest('l_name_ar');
$location            = filterRequest('location');
$location            = filterRequest('location_ar');
$trip_long_favorite  = filterRequest('trip_long_favorite');

$favorite_1  = filterRequest('favorite_1');
$favorite_2  = filterRequest('favorite_2');
$favorite_3  = filterRequest('favorite_3');
$favorite_4  = filterRequest('favorite_4');


$stmt = $con->prepare("SELECT * FROM `account` WHERE `ID` = ?");
$stmt->execute(array($account_id));
$count_acc = $stmt->rowCount();

$stmt = $con->prepare("SELECT * FROM `user` WHERE `account_id` = ?");
$stmt->execute(array($account_id));
$count_user = $stmt->rowCount();

if ($count_acc > 0 && $count_user == 0) {
    $data = array(
        "account_id"             => $account_id,
        "f_name"                 => $f_name,
        "f_name_ar"              => $f_name_ar,
        "l_name"                 => $l_name,
        "l_name_ar"              => $l_name_ar,
        "location"               => $location,
        "location_ar"            => $location_ar,
        "trip_long_favorite"     => $trip_long_favorite,
    );
    [$count1, $user_id] = insertData("user", $data);
    if ($count1 > 0) {
        $data1 = array(
            "user_id"    => $user_id,
            "favorite_1" => $favorite_1,
            "favorite_2" => $favorite_2,
            "favorite_3" => $favorite_3,
            "favorite_4" => $favorite_4,
        );
        insertData("user_favorites", $data1);
    }
} elseif ($count_acc == 0) {
    printFailure("Account not existed");
} else {
    printFailure("User had already registered");
}

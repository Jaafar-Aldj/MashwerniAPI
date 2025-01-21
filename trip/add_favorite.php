<?php

include "../connect.php";

$userID     = filterRequest("user_id");
$tripNUM    = filterRequest("trip_num");
$data = array(
    "favorite_user_id"  => $userID,
    "favorite_trip_num" => $tripNUM,
);
insertData('favorite', $data);

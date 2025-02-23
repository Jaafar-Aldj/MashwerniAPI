<?php

include "../connect.php";

$userID     = filterRequest("user_id");
$tripNUM    = filterRequest("trip_num");

$data = array(
    "booking_user_id"  => $userID,
    "booking_trip_num" => $tripNUM,
);
insertData("booking", $data);

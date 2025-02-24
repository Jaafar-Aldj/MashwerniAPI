<?php

include "../connect.php";

$userID     = filterRequest("user_id");
$tripNUM    = filterRequest("trip_num");

$stmt = $con->prepare("SELECT COUNT(booking.booking_id) AS count FROM `booking` WHERE booking_trip_num = $tripNUM AND booking_user_id = $userID ");
$stmt->execute();

$data = $stmt->fetchColumn();

echo json_encode(array("status" => "success", "data" => $data));

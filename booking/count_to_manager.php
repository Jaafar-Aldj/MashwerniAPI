<?php

include "../connect.php";

$tripNUM    = filterRequest("trip_num");

$stmt = $con->prepare("SELECT COUNT(booking.booking_id) AS count FROM `booking` WHERE booking_trip_num = $tripNUM");
$stmt->execute();

$data = $stmt->fetchColumn();

echo json_encode(array("status" => "success", "data" => $data));

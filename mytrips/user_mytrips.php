<?php
include "../connect.php";

$userID     = filterRequest("user_id");

$alldata = array();
$alldata['status'] = 'success';
$current_time = date("Y-m-d");

$stmt = $con->prepare("SELECT DISTINCT itemview.*  FROM itemview
INNER JOIN booking ON itemview.trip_num = booking.booking_trip_num AND booking.booking_user_id = :userID
WHERE itemview.start_date > :currentTime
GROUP BY itemview.trip_num");
$stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
$stmt->bindParam(':currentTime', $current_time, PDO::PARAM_STR);
$stmt->execute();
$upComingTrips = $stmt->fetchAll(PDO::FETCH_ASSOC);
$alldata['up_coming_trips'] = $upComingTrips;

$stmt = $con->prepare("SELECT DISTINCT itemview.*  FROM itemview
INNER JOIN booking ON itemview.trip_num = booking.booking_trip_num AND booking.booking_user_id = :userID
WHERE itemview.start_date < :currentTime
GROUP BY itemview.trip_num");
$stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
$stmt->bindParam(':currentTime', $current_time, PDO::PARAM_STR);
$stmt->execute();
$lastTrips = $stmt->fetchAll(PDO::FETCH_ASSOC);
$alldata['last_trips'] = $lastTrips;

echo json_encode($alldata);

<?php
include "../connect.php";

$managerID     = filterRequest("manager_id");

$alldata = array();
$alldata['status'] = 'success';
$current_time = date("Y-m-d");

$upComingTrips = getAllData('itemview', "start_date > ? AND manager_id = ?", array($current_time, $managerID), false);
$alldata['up_coming_trips'] = $upComingTrips;

$lastTrips = getAllData('itemview', "start_date < ? AND manager_id = ?", array($current_time, $managerID), false);
$alldata['last_trips'] = $lastTrips;

echo json_encode($alldata);

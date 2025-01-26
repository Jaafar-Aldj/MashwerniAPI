<?php

include '../connect.php';

$manager_id      = filterRequest('manager_id');
$title           = filterRequest('title');
$start_date      = filterRequest('start_date');
$end_date        = filterRequest('end_date');
$start_location  = filterRequest('start_location');
$description     = filterRequest('description');
$type            = filterRequest('type');
$max_passengers  = filterRequest('max_passengers');
$cost            = filterRequest('cost');

// destination
$location_1  = filterRequest('location_1');
$location_2  = filterRequest('location_2');
$location_3  = filterRequest('location_3');
$location_4  = filterRequest('location_4');
$location_5  = filterRequest('location_5');

// images
// TODO : img_1



$stmt = $con->prepare("SELECT * FROM `manager` WHERE `ID` = ?");
$stmt->execute(array($manager_id));
$count = $stmt->rowCount();

if ($count > 0) {
    $data = array(
        "manager_id"        => $manager_id,
        "title"             => $title,
        "start_date"        => $start_date,
        "end_date"          => $end_date,
        "start_location"    => $start_location,
        "description"       => $description,
        "type"              => $type,
        "max_passengers"    => $max_passengers,
        "cost"              => $cost,
    );
    [$count1, $trip_num] = insertData("trip", $data);
    if ($count1 > 0) {
        $data1 = array(
            "trip_num"   => $trip_num,
            "location_1" => $location_1,
            "location_2" => $location_2,
            "location_3" => $location_3,
            "location_4" => $location_4,
            "location_5" => $location_5,
        );
        insertData("trip_destination", $data1);
    }
} elseif ($count == 0) {
    printFailure("No like manager");
}

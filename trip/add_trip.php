<?php

include '../connect.php';

$manager_id         = filterRequest('manager_id');
$title              = filterRequest('title');
$title_ar           = filterRequest('title_ar');
$start_date         = filterRequest('start_date');
$trip_long          = filterRequest('trip_long');
$start_location     = filterRequest('start_location');
$start_location_ar  = filterRequest('start_location_ar');
$description        = filterRequest('description');
$description_ar     = filterRequest('description_ar');
$category_id        = filterRequest('category_id');
$max_passengers     = filterRequest('max_passengers');
$cost               = filterRequest('cost');

// destination
$location_1     = filterRequest('location_1') ?? "";
$location_2     = filterRequest('location_2') ?? "";
$location_3     = filterRequest('location_3') ?? "";
$location_4     = filterRequest('location_4') ?? "";
$location_5     = filterRequest('location_5') ?? "";
$location_1_ar  = filterRequest('location_1_ar') ?? "";
$location_2_ar  = filterRequest('location_2_ar') ?? "";
$location_3_ar  = filterRequest('location_3_ar') ?? "";
$location_4_ar  = filterRequest('location_4_ar') ?? "";
$location_5_ar  = filterRequest('location_5_ar') ?? "";

// images
$img_1 = filterRequest('image_1') ?? "";
$img_2 = filterRequest('image_2') ?? "";
$img_3 = filterRequest('image_3') ?? "";
$img_4 = filterRequest('image_4') ?? "";
$img_5 = filterRequest('image_5') ?? "";



$stmt = $con->prepare("SELECT * FROM `manager` WHERE `ID` = ?");
$stmt->execute(array($manager_id));
$count = $stmt->rowCount();

if ($count > 0) {
    $data = array(
        "manager_id"        => $manager_id,
        "title"             => $title,
        "title_ar"          => $title_ar,
        "start_date"        => $start_date,
        "trip_long"         => $trip_long,
        "start_location"    => $start_location,
        "start_location_ar" => $start_location_ar,
        "description"       => $description,
        "description_ar"    => $description_ar,
        "category_id"       => $category_id,
        "max_passengers"    => $max_passengers,
        "cost"              => $cost,
    );
    [$count1, $trip_num] = insertData("trip", $data, false);
    if ($count1 > 0) {
        $data1 = array(
            "trip_num"      => $trip_num,
            "location_1"    => $location_1,
            "location_2"    => $location_2,
            "location_3"    => $location_3,
            "location_4"    => $location_4,
            "location_5"    => $location_5,
            "location_1_ar" => $location_1_ar,
            "location_2_ar" => $location_2_ar,
            "location_3_ar" => $location_3_ar,
            "location_4_ar" => $location_4_ar,
            "location_5_ar" => $location_5_ar,
        );
        insertData("trip_destination", $data1, false);
        $data2 = array(
            "trip_num" => $trip_num,
            "img_1"    => $img_1,
            "img_2"    => $img_2,
            "img_3"    => $img_3,
            "img_4"    => $img_4,
            "img_5"    => $img_5,
        );
        insertData("trip_images", $data2, false);
        echo json_encode(array("status" => "success", "trip_num" => $trip_num));
    } else {
        printFailure("destination has not added");
    }
} elseif ($count == 0) {
    printFailure("No like manager");
}

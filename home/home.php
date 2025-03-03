<?php
include "../connect.php";

$userID = filterRequest("user_id");
$user_data = getData("user", "ID = ?", array($userID), false);
$user_location = parseLocation($user_data['location']);
$user_location_ar = parseLocation($user_data['location_ar']);
$user_trip_duration = $user_data['trip_long_favorite'];

$user_location_str = $user_data['location'];
$user_location_ar_str = $user_data['location_ar'];

$alldata = array();
$alldata['status'] = 'success';
$current_time = date("Y-m-d");

$categories = getAllData('categories', '1=1', null, false);
$alldata['categories'] = $categories;
$items = getAllData('itemview', "start_date > ?", array($current_time), false);
$alldata['items'] = $items;

$suggestedTrips = [];

foreach ($items as $item) {
    $trip_location = parseLocation($item['start_location']);
    $trip_location_ar = parseLocation($item['start_location_ar']);
    $trip_duration = $item['trip_long'];

    $user_vector = array_merge($user_location, $user_location_ar, [$user_trip_duration]);
    $trip_vector = array_merge($trip_location, $trip_location_ar, [$trip_duration]);

    // حساب التشابه
    $similarity = cosineSimilarity($user_vector, $trip_vector);

    // حفظ النتيجة
    $item['similarity'] = $similarity;
    $suggestedTrips[] = $item;
}
usort($suggestedTrips, function ($a, $b) {
    return $b['similarity'] <=> $a['similarity'];
});

$alldata['suggested_trips'] = $suggestedTrips;

$tripsFrom = getAllData('itemview', "start_date > ? AND (start_location = ? OR start_location_ar = ?)", array($current_time, $user_location_str, $user_location_ar_str), false);
$alldata['trips_from'] = $tripsFrom;
$alldata['location'] = $user_location_str;
$alldata['location_ar'] = $user_location_ar_str;

echo json_encode($alldata);

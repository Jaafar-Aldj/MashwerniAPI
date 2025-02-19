<?php
include "../connect.php";

// $items = getAllData('itemview', "category_id = $categoryID");

$categoryID = filterRequest('category_id');
$userID = filterRequest('user_id');
$current_time = date("Y-m-d");

$stmt = $con->prepare("SELECT itemview.* ,1 AS favorite FROM itemview
INNER JOIN favorite ON itemview.trip_num = favorite.favorite_trip_num AND favorite.favorite_user_id = :userID
WHERE category_id = :categoryID AND itemview.start_date > :currentTime
UNION ALL
SELECT itemview.* ,0 AS favorite FROM itemview
WHERE category_id = :categoryID AND itemview.start_date > :currentTime AND itemview.trip_num NOT IN (SELECT itemview.trip_num FROM itemview
INNER JOIN favorite ON itemview.trip_num = favorite.favorite_trip_num AND favorite.favorite_user_id = :userID)");
$stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
$stmt->bindParam(':categoryID', $categoryID, PDO::PARAM_INT);
$stmt->bindParam(':currentTime', $current_time, PDO::PARAM_STR);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = $stmt->rowCount();

if ($count > 0) {
    echo json_encode(array("status" => "success", "data" => $data));
} else {
    echo json_encode(array("status" => "failure"));
}

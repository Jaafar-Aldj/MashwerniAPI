<?php
include "../connect.php";

// $items = getAllData('itemview', "category_id = $categoryID");

$categoryID = filterRequest('category_id');
$userID = filterRequest('user_id');

$stmt = $con->prepare("SELECT itemview.* ,1 AS favorite FROM itemview
INNER JOIN favorite ON itemview.trip_num = favorite.favorite_trip_num AND favorite.favorite_user_id = $userID
WHERE category_id = $categoryID
UNION ALL
SELECT itemview.* ,0 AS favorite FROM itemview
WHERE category_id = $categoryID AND itemview.trip_num NOT IN (SELECT itemview.trip_num FROM itemview
INNER JOIN favorite ON itemview.trip_num = favorite.favorite_trip_num AND favorite.favorite_user_id = $userID)");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = $stmt->rowCount();

if ($count > 0) {
    echo json_encode(array("status" => "success", "data" => $data));
} else {
    echo json_encode(array("status" => "failure"));
}

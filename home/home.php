<?php
include "../connect.php";
$alldata = array();
$alldata['status'] = 'success';
$current_time = date("Y-m-d");

$categories = getAllData('categories', '1=1', null, false);
$alldata['categories'] = $categories;
$items = getAllData('itemview', "start_date > ?", array($current_time), false);
$alldata['items'] = $items;

echo json_encode($alldata);

<?php
include "../connect.php";
$alldata = array();
$alldata['status'] = 'success';

$categories = getAllData('categories', '1=1', null, false);
$alldata['categories'] = $categories;
$items = getAllData('itemview', '1=1', null, false);
$alldata['items'] = $items;

echo json_encode($alldata);

<?php
include "../connect.php";

$categoryID = filterRequest('id');
$items = getAllData('itemview', "category_id = $categoryID");

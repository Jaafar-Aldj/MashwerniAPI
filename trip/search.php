<?php

include "../connect.php";

$current_time = date("Y-m-d");
$search = filterRequest("search");

getAllData("itemview", "start_date > '$current_time' AND (title LIKE '%$search%' OR title_ar LIKE '%$search%') ");

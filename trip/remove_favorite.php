<?php

include "../connect.php";

$userID     = filterRequest("user_id");
$tripNUM    = filterRequest("trip_num");


deleteData('favorite', "favorite_user_id = $userID AND favorite_trip_num = $tripNUM");

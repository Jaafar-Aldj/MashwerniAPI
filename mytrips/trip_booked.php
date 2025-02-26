<?php

include "../connect.php";

$tripNUM    = filterRequest("trip_num");

getAllData('trip_booked', "trip_num = ?", array($tripNUM));

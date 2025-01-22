<?php

include "../connect.php";

$userID     = filterRequest("user_id");

getAllData("myfavorite", "favorite_user_id = ?", array($userID));

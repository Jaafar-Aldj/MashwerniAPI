<?php

include "../connect.php";

$favoriteID     = filterRequest("favorite_id");


deleteData('favorite', "favorite_id = $favoriteID");

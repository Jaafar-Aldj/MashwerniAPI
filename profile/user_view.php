<?php
include "../connect.php";

$userID     = filterRequest("user_id");

$stmt = $con->prepare("SELECT 
	user.*,
    account.email,
    account.phone
FROM `user`
INNER JOIN `account` ON account.ID = user.account_id
WHERE user.ID = :userID");
$stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
$stmt->execute();
$count = $stmt->rowCount();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($count > 0) {
    echo json_encode(array("status" => "success", "data" => $data));
} else {
    echo json_encode(array("status" => "failure"));
}

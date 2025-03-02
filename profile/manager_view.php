<?php
include "../connect.php";

$managerID     = filterRequest("manager_id");

$stmt = $con->prepare("SELECT 
	manager.*,
    account.email,
    account.phone
FROM `manager`
INNER JOIN `account` ON account.ID = manager.account_id
WHERE manager.ID = :managerID");
$stmt->bindParam(':managerID', $managerID, PDO::PARAM_INT);
$stmt->execute();
$count = $stmt->rowCount();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($count > 0) {
    echo json_encode(array("status" => "success", "data" => $data));
} else {
    echo json_encode(array("status" => "failure"));
}

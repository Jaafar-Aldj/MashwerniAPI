<?php

define("MB", 1048576);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function filterRequest($requestname)
{
    return  htmlspecialchars(strip_tags($_POST[$requestname]));
}

function getAllData($table, $where = "1=1", $values = null, $json = true)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT  * FROM `$table` WHERE   $where ");
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
        return $count;
    } else {
        if ($count > 0) {
            return $data;
        } else {
            return null;
        }
    }
}
function getData($table, $where = "1=1", $values = null, $json = true)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT  * FROM `$table` WHERE   $where ");
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
        return $count;
    } else {
        if ($count > 0) {
            return $data;
        } else {
            return null;
        }
    }
}

function insertData($table, $data, $json = true)
{
    global $con;
    foreach ($data as $field => $v)
        $ins[] = ':' . $field;
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO `$table` ($fields) VALUES ($ins)";
    try {
        $stmt = $con->prepare($sql);
        foreach ($data as $f => $v) {
            $stmt->bindValue(':' . $f, $v);
        }
        $stmt->execute();
        $count = $stmt->rowCount();
        $id = $con->lastInsertId();
        if ($json) {
            if ($count > 0) {
                echo json_encode(array("status" => "success"));
            } else {
                echo json_encode(array("status" => "failure", "error" => "email or phone"));
            }
        }
        return [$count, $id];
    } catch (PDOException $e) {
        echo json_encode(array("status" => "failure", "error" => $e->getMessage()));
        return 0; // Return 0 to indicate failure
    }
}


function updateData($table, $data, $where, $json = true)
{
    global $con;
    $cols = [];
    $vals = [];

    foreach ($data as $key => $val) {
        $cols[] = "`$key` =  ? ";
        $vals[] = "$val";
    }
    $sql = "UPDATE `$table` SET " . implode(', ', $cols) . " WHERE $where";

    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

function deleteData($table, $where, $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM `$table` WHERE $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

function imageUpload($imageRequest)
{
    global $msgError;
    $imagename  = rand(1000, 10000) . $_FILES[$imageRequest]['name'];
    $imagetmp   = $_FILES[$imageRequest]['tmp_name'];
    $imagesize  = $_FILES[$imageRequest]['size'];
    $allowExt   = array("jpg", "png", "gif", "mp3", "pdf");
    $strToArray = explode(".", $imagename);
    $ext        = end($strToArray);
    $ext        = strtolower($ext);

    if (!empty($imagename) && !in_array($ext, $allowExt)) {
        $msgError = "EXT";
    }
    if ($imagesize > 2 * MB) {
        $msgError = "size";
    }
    if (empty($msgError)) {
        move_uploaded_file($imagetmp,  "../upload/" . $imagename);
        return $imagename;
    } else {
        return "fail";
    }
}



function deleteFile($dir, $imagename)
{
    if (file_exists($dir . "/" . $imagename)) {
        unlink($dir . "/" . $imagename);
    }
}

function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != "wael" ||  $_SERVER['PHP_AUTH_PW'] != "wael12345") {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }
}

function printFailure($message = "Unknown")
{
    echo json_encode(array("status" => "failure", "message" => $message));
}

function printSuccess($message = "Unknown")
{
    echo json_encode(array("status" => "success", "message" => $message));
}

function result($count, $message = "Unknown")
{
    if ($count > 0) {
        printSuccess($message);
    } else {
        printFailure($message);
    }
}

function sendMail($to, $title, $body)
{

    $mail = new PHPMailer(true); // Create a new PHPMailer instance

    try {
        // SMTP Server settings
        $mail->isSMTP();  // Set the mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Use Gmail's SMTP server
        $mail->SMTPAuth = true;  // Enable SMTP authentication
        $mail->Username = 'jaafaraldoj@gmail.com';  // Your Gmail email
        $mail->Password = 'czdc evzd bing kxfd';  // Use an app password if 2FA is enabled
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
        $mail->Port = 587;  // Port for sending emails via Gmail

        // Recipients
        $mail->setFrom('jaafaraldoj@gmail.com', 'Mashwerni');  // Sender's email
        $mail->addAddress($to);  // Recipient's email

        // Email Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = $title;
        $mail->Body = $body;
        //$mail->AltBody = '';

        // Send the email
        if ($mail->send()) {
        }
    } catch (Exception $e) {
    }
}


function sendGCM($title, $message, $topic, $pageid, $pagename)
{


    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array(
        "to" => '/topics/' . $topic,
        'priority' => 'high',
        'content_available' => true,

        'notification' => array(
            "body" =>  $message,
            "title" =>  $title,
            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            "sound" => "default"

        ),
        'data' => array(
            "pageid" => $pageid,
            "pagename" => $pagename
        )

    );


    $fields = json_encode($fields);
    $headers = array(
        'Authorization: key=' . "",
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $result = curl_exec($ch);
    return $result;
    curl_close($ch);
}



function cosineSimilarity($vectorA, $vectorB)
{
    $dotProduct = 0.0;
    $normA = 0.0;
    $normB = 0.0;

    for ($i = 0; $i < count($vectorA); $i++) {
        $dotProduct += $vectorA[$i] * $vectorB[$i];
        $normA += pow($vectorA[$i], 2);
        $normB += pow($vectorB[$i], 2);
    }

    if ($normA == 0 || $normB == 0) {
        return 0;
    }

    return $dotProduct / (sqrt($normA) * sqrt($normB));
}


function parseLocation($locationString)
{
    $parts = explode(",", $locationString);
    if (count($parts) == 2) {
        return [floatval($parts[0]), floatval($parts[1])];
    }
    return [0.0, 0.0];
}

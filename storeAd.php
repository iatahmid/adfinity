<?php

/**
 * @author Taha
 */

require_once 'include/DB_Functions_Event.php';
$db = new DB_Functions_Event();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['title']) && isset($_POST['price'])) {

    // receiving the post params
    $title = $_POST['title'];
    $price = $_POST['price'];

    if(isset($_POST['details'])) $details = $_POST['details'];
    else $details = " ";

    if(isset($_POST['link'])) $link = $_POST['link'];
    else $link = " ";

    $ad = $db->storeAd($title, $price, $details, $link);
    
    if ($ad) {

        $response["error"] = FALSE;
        echo json_encode($response);

    } else {

        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in storing ad!";

        echo json_encode($response);
    }
} else {

    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters are missing!";
    
    echo json_encode($response);
}
?>
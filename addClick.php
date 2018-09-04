<?php

/**
 * @author Taha
 */

require_once 'include/DB_Functions_Event.php';
$db = new DB_Functions_Event();

// json response array
$response = array("error" => FALSE);

if(!isset($_POST['ad_id'])){
    $response["ad_id"] = "missing";
}

if(!isset($_POST['user_id'])){
    $response["user"] = "missing";
}

if (isset($_POST['ad_id']) && isset($_POST['user_id'])) {

    // receiving the post params
    $ad = $_POST['ad_id'];
    $user = $_POST['user_id'];
    
    // create a new interest
    $click = $db->addClick($ad, $user);
    
    if ($click) {
        $response["error"] = FALSE;
        
        echo json_encode($response);
    } else {
        // event failed to store
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in storing interest!";

        /*db->storeTestEvent();*/

        echo json_encode($response);
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters are missing!";
    
    /*db->storeTestEvent();*/

    echo json_encode($response);
}
?>


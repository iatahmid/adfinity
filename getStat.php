<?php

/**
 * @author Taha
 */

require_once 'include/DB_Functions_Event.php';
$db = new DB_Functions_Event();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['ad_id'])) {

    /*db->storeTestEvent();*/

    // receiving the post params
    $id = $_POST['ad_id'];

    // 
    $result = $db->getAdStat($id);
    
    if ($result) {

        $response["error"] = FALSE;
        echo json_encode($response);
    } else {

        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in getting stat!";

        echo json_encode($response);
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters are missing!";
    
    echo json_encode($response);
}
?>


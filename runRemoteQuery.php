<?php

/**
 * @author Taha
 */

require_once 'include/DB_Connect.php';
// connecting to database
$db = new Db_Connect();
$conn = $db->connect();

$query  = 'DELETE FROM diu_ad WHERE id = 8';

$result = mysqli_query($conn, $query);
if($result){
    echo "SUCCESS";
}
else{
    echo "failed";
}

?>


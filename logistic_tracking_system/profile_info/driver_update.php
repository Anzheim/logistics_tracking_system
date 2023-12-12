<?php
$link=require_once "../config.php";
session_start();

if($_SESSION["loggedin"] == false){
    echo'<script>alert("請重新登入"); window.location="../";</script>';
    exit();
}
if(!$link){
    die( print_r( sqlsrv_errors(), true));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the selected value is set in the POST data
    if (isset($_POST['order_status_' . $_POST['order_id']], $_POST['order_id'])) {
        $selectedStatusId = $_POST['order_status_' . $_POST['order_id']];
        $order_id = $_POST['order_id'];
        echo 'alert("' . $_POST['order_status_' . $_POST['order_id']] . ' + ' . $order_id . '");';
        // Update the database
        $updateSql = "UPDATE orders SET status_id = '$selectedStatusId' WHERE order_id = '$order_id'";
        $updateStmt = sqlsrv_prepare($link, $updateSql, array(&$selectedStatusId, &$driver_id));
        sqlsrv_execute($updateStmt);

        if ($updateStmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }
}
header("location: driver.php");
?>
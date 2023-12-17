<?php
$pdo=require_once "./config.php";
session_start();
if($_SESSION["admin_loggedin"] == false){
    echo'<script>alert("請重新登入"); window.location="../";</script>';
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the selected value is set in the POST data
    if (isset($_POST['order_status_' . $_POST['order_id']], $_POST['order_id'])&& $_POST['update'] === 'true') {
        $selectedStatusId = $_POST['order_status_' . $_POST['order_id']];
        $order_id = $_POST['order_id'];
        echo 'alert("' .$selectedStatusId. ' + ' . $order_id . '");';
        // Update the database
        $sql = "UPDATE orders SET status_id = :selectedStatusId WHERE order_id = :order_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':selectedStatusId', $selectedStatusId, PDO::PARAM_STR);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_STR);
        $stmt->EXECUTE();
    }
    if(isset($_POST['order_id'])&& $_POST['delete'] === 'true'){
        $order_id = $_POST['order_id'];
        // Update the database
        $sql = "DELETE FROM orders WHERE order_id = :order_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_STR);
        $stmt->EXECUTE();
    }
}
header("location: admin.php");
?>

<?php
$pdo=require_once "./config.php";
session_start();
if($_SESSION["admin_loggedin"] == false){
    echo'<script>alert("請重新登入"); window.location="../";</script>';
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the selected value is set in the POST data
    if (isset($_POST['order_id'], $_POST['buyer_id'], $_POST['seller_id'], $_POST['driver_id'])) {
        $order_id = $_POST['order_id'];
        $buyer_id = $_POST['buyer_id'];
        $seller_id = $_POST['seller_id'];
        $driver_id = $_POST['driver_id'];

        $sql1 = "SELECT buyer_name, buyer_address FROM buyer WHERE buyer_id = :buyer_id";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->bindParam(':buyer_id', $buyer_id, PDO::PARAM_STR);
        $stmt1->EXECUTE();
        $row1 = $stmt1->fetch();
        $buyer_name = $row1['buyer_name'];
        $buyer_address = $row1['buyer_address'];

        $sql2 = "SELECT seller_id FROM seller WHERE seller_id = :seller_id";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(':seller_id', $seller_id, PDO::PARAM_STR);
        $stmt2->EXECUTE();
        $row2 = $stmt2->fetch();
        $seller_auth = $row2['seller_id'];

        $sql3 = "SELECT driver_id FROM driver WHERE driver_id = :driver_id";
        $stmt3 = $pdo->prepare($sql3);
        $stmt3->bindParam(':driver_id', $driver_id, PDO::PARAM_STR);
        $stmt3->EXECUTE();
        $row3 = $stmt3->fetch();
        $driver_auth = $row3['driver_id'];

        $sql4 = "SELECT order_id FROM orders WHERE order_id = :order_id";
        $stmt4 = $pdo->prepare($sql4);
        $stmt4->bindParam(':order_id', $order_id, PDO::PARAM_STR);
        $stmt4->EXECUTE();
        $row4 = $stmt4->fetch();
        $order_auth = $row4['order_id'];

        if($buyer_name==NULL || $seller_auth==NULL || $driver_auth==NULL || $order_auth != NULL){
            echo "<script>alert('新增訂單失敗，請檢查輸入值 Order ID：$order_id | Buyer ID：$buyer_id | Seller ID：$seller_id | Driver ID：$driver_id');location.href='./admin.php'</script>";
        }

        $data = [
           'order_id' => $order_id,
           'buyer_id' => $buyer_id,
           'seller_id' => $seller_id,
           'driver_id' => $driver_id,
           'admin_id' => 'A001',
           'buyer_name' => $buyer_name,
           'buyer_address' => $buyer_address,
           'date_time' => date("Y-m-d H:i:s"),
           'status_id' => 1,
        ];

        $sql5 = "INSERT INTO orders(order_id, buyer_id, seller_id, driver_id, admin_id, buyer_name, buyer_address,date_time, status_id) values(:order_id,:buyer_id,:seller_id,:driver_id, :admin_id,:buyer_name,:buyer_address,:date_time,:status_id)";
        $stmt5 = $pdo->prepare($sql5);
        $stmt5->EXECUTE($data);
    }
}
header("location: admin.php");
?>

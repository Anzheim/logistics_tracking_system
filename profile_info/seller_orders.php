<?php
$link=require_once "../config.php";

session_start();
$seller_id = $_SESSION["seller_id"];
$seller_name=$_SESSION["seller_name"];
$seller_address=$_SESSION["seller_address"];
if($_SESSION["loggedin"] == false){
    echo'<script>alert("請重新登入"); window.location="../";</script>';
    exit();
}

if(!$link){
    die( print_r( sqlsrv_errors(), true));
}
$sql = "SELECT orders.order_id, orders.date_time, status_name
        FROM orders JOIN order_status ON orders.status_id = order_status.status_id
        WHERE orders.seller_id = '$seller_id'";
$stmt = sqlsrv_query( $link, $sql );
if(!$stmt){
    die( print_r( sqlsrv_errors(), true));
}
if(!sqlsrv_has_rows($stmt)){
    echo '<script>
    alert("沒有您的訂單！"); 
    location.href="./seller_login.html";
    </script>';
}

$i = 0;
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC ) ) {
    // echo $row['order_id']."</br>";
    // echo $row['date_time']->format("Y-m-d H:i:s")."<br>";
    $i += 1;
    echo '
        <div class="orders" id="orders'.$i.'">
            <button id="order_button'.$i.'" onclick="displayOrderContent('.$i.', \'' . $row['date_time']->format("Y-m-d H:i:s") . '\', \''. $row['status_name'].'\')">
                '.$row['order_id'].'
            </button>
            <div id="order_content'.$i.'">訂單詳細資料</div>
        </div>
    ';
}
sqlsrv_free_stmt($stmt);
sqlsrv_close($link);
?>
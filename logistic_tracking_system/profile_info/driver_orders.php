<?php
$link=require_once "../config.php";

session_start();
$driver_id = $_SESSION["driver_id"];
$driver_name=$_SESSION["driver_name"];
if($_SESSION["loggedin"] == false){
    echo'<script>alert("請重新登入"); window.location="../";</script>';
    exit();
}

if(!$link){
    die( print_r( sqlsrv_errors(), true));
}

$sql = "SELECT orders.order_id, orders.date_time, order_status.status_id, order_status.status_name
        FROM orders JOIN order_status ON orders.status_id = order_status.status_id
        WHERE orders.driver_id = '$driver_id'";

$stmt = sqlsrv_query( $link, $sql );
if(!$stmt){
    die( print_r( sqlsrv_errors(), true));
}

if(!sqlsrv_has_rows($stmt)){
    echo '<script>
    alert("沒有訂單！"); 
    location.href="./driver_login.html";
    </script>';
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the selected value and order_id are set in the POST data
    if (isset($_POST['order_status'], $_POST['order_id'])) {
        $_SESSION["order_status"] = $_POST['order_status'];
        $_SESSION["order_id"] = $_POST['order_id'];
    }
}


$i = 0;
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC ) ) {
    $i += 1;
     //Output options excluding the selected one
    $selectedStatusId = $row['status_id'];
    echo '
        <div class="orders" id="orders'.$i.'">
            <h2 id="order_header'.$i.'">
                '.$row['order_id'].'
            </h2>
            <div id="order_content'.$i.'"><strong>訂單時間</strong>：'.$row['date_time']->format("Y-m-d H:i:s").'<br><strong>訂單狀態：'.$row['status_name'].'</strong>
                <form action="driver_update.php" method="POST">
                    <select name="order_status_'.$row['order_id'].'" id="order_of_'.$i.'" aria-label="order"">
                        ';
    $options=[
        ['value' => '3', 'label' => 'Shipped'],
        ['value' => '4', 'label' => 'Delivered'],
    ];
    foreach($options as $option){
        $selected = ($option['value']==$selectedStatusId)? 'selected':'';
        echo '<option value="'.$option['value'].'" '.$selected.'>'.$option['label'].'</option>';
    }
    echo '
                    </select>
                    <input type="hidden" name="order_id" value="'.$row['order_id'].'">
                    <button type="submit" value="更新訂單狀態">更新訂單狀態</button>      
                </form>
            </div>
        </div>
    ';
}
sqlsrv_free_stmt($stmt);
sqlsrv_close($link);
?>
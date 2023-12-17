<?php
    $pdo=require_once "./config.php";
    session_start();
    $driver_id = $_SESSION["driver_id"];
    if($_SESSION["loggedin"] == false){
        echo'<script>alert("請重新登入"); window.location="../";</script>';
        exit();
    }

    $sql = "SELECT orders.order_id, orders.date_time, order_status.status_id, order_status.status_name
            FROM orders JOIN order_status ON orders.status_id = order_status.status_id
            WHERE orders.driver_id = :driver_id";
try{
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':driver_id', $driver_id, PDO::PARAM_STR);
    $stmt->EXECUTE();

    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    if($rows===false){
       echo '<strong>查無訂單<strong>';
    }
    $i=0;
    foreach($rows as $row){
        $i += 1;
        $selectedStatusId = $row['status_id'];
        echo '
            <div class="orders" id="orders'.$i.'"> 
                <h2 id="order_header'.$i.'">
                    '.$row["order_id"].'
                </h2>
                <div id="order_content'.$i.'"><strong>訂單時間</strong>：'.$row['date_time'].'<br><strong>訂單狀態：'.$row['status_name'].'</strong>
                    <form action="driver_update.php" method="POST">
                        <select name="order_status_'.$row['order_id'].'" id="order_of_$i" aria-label="order">
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
}catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    echo "PDO error code: " . $e->getCode();
}
    $pdo=NULL;
?>

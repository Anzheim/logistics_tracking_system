<?php
    session_start();
    $admin_id = $_SESSION["admin_id"];
    if($_SESSION["admin_loggedin"] == false){
        echo'<script>alert("請重新登入"); window.location="./";</script>';
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logistics Tracking System</title>
    <link rel="stylesheet" href="./css/styles_of_list.css?v=?=time()"> <!--測試用參數記得刪-->
</head>
<body>
    <header>
        <h1>物流追蹤系統</h1>
        <button id ="logout" onclick="location.href='./logout.php'">登出</button>
    </header>

    <section id="user-info">
        <h2>管理者資訊</h2>
        <p><strong>管理者：<strong><spqn id="admin-id"><?php echo $admin_id ?></span></p>
    </section>
    <script>
        function viewAllLists(){
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.status == 200) {
                        var ordersElement = document.getElementById("order_list");
                        ordersElement.innerHTML = xhr.responseText;
                }else{
                    console.error("HTTP request failed with status:", xhr.status);
                }
            };
            xhr.open("GET", "./view_all_orders.php", true);
            xhr.send();
        }
        viewAllLists();
    </script>
    <form id="insert" action="insert_order.php" method="POST">
        <label for="order_id">訂單 ID</label>
        <input id="order_id" name="order_id" placeholder="O001">
        <label for="buyer_id">買家 ID</label>
        <input id="buyer_id" name="buyer_id" placeholder="B001">
        <label for="seller_id">賣家 ID</label>
        <input id="seller_id" name="seller_id" placeholder="S001">
        <label for="driver_id">司機 ID</label>
        <input id="driver_id" name="driver_id" placeholder="D001">
        <button type="submit" id="insert_button">新增訂單</button>
    </form>
        <div id="order_list"></div>
    <footer>
        <p>&copy; 2023 Logistics Tracking System</p>
    </footer>
</body>
</html>

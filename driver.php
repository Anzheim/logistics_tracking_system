<?php
    session_start();
    $driver_id = $_SESSION["driver_id"];
    $driver_name = $_SESSION["driver_name"];
    if($_SESSION["loggedin"] == false){
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
    <link rel="stylesheet" href="../css/styles_of_list.css?v=?=time()"> <!--測試用參數記得刪-->
</head>
<body>
    <header>
        <h1>物流追蹤系統</h1>
        <button id ="logout" onclick="location.href='./logout.php'">登出</button>
    </header>

    <section id="user-info">
        <h2>司機資訊</h2>
        <p><strong>司機ID：<strong><spqn id="driver-id"><?php echo $driver_id ?></span></p>
        <p><strong>姓名:</strong> <span id="driver-name"><?php echo $driver_name ?></span></p>
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
            xhr.open("GET", "./view_driver_orders.php", true);
            xhr.send();
        }
        viewAllLists();
    </script>
    <div id="order_list"></div>
    <footer>
        <p>&copy; 2023 Logistics Tracking System</p>
    </footer>
</body>
</html>

<?php
    session_start();
    $buyer_name=$_SESSION["buyer_name"];
    $buyer_address=$_SESSION["buyer_address"];
    
    if($_SESSION["loggedin"] == false){
       echo'<script>alert("請重新登入"); window.location="../";</script>';
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
        <button id ="logout" onclick="location.href='../logout.php'">登出</button>
    </header>
    
    <section id="user-info">
        <h2>買家資訊</h2>
        <p><strong>姓名:</strong> <span id="buyer-name"><?php echo $buyer_name ?></span></p>
        <p><strong>地址:</strong> <span id="buyer-address"><?php echo $buyer_address ?></span></p>
    </section>
    
    <section id="action-buttons">
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
                xhr.open("GET", "./buyer_orders.php", true);
                xhr.send();
            }
            function displayOrderContent(index, order_time, order_status){
                document.getElementById("order_content" + index).innerHTML = "<strong>訂單時間</strong>："+order_time+"<br>訂單狀態："+order_status;
            }
        </script>
        <button id="view_list" onclick="viewAllLists()">查看所有訂單</button>
        <div id="order_list"></div>
    </section>

    <footer>
        <p>&copy; 2023 Logistics Tracking System</p>
    </footer>
</body>
</html>
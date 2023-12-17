<?php
$pdo=require_once "./config.php";

$order_id = $_POST['order_id'];

$sql = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$order_id]);

$row = $stmt->fetch();

$status_descriptions = [
    1 => '等待中',
    2 => '處理中',
    3 => '已發貨',
    4 => '已交付',
    5 => '已取消',
    6 => '已完成'
];

if (!$row) {
    echo "<script>alert('未找到指定的訂單');
    location.href='./';</script>
    ";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>訂單詳情</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .order-details {
            width: 400px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .order-info {
            margin-top: 20px;
        }

        .order-info p {
            margin: 10px 0;
            font-size: 16px;
            color: #555;
        }

        .order-info strong {
            font-weight: bold;
            margin-right: 8px;
            color: #333;
        }

        .order-status {
            margin-top: 20px;
        }

        .order-status p {
            font-size: 18px;
            font-weight: bold;
            color: #009688;
            margin: 0;
        }

        .status-icon {
            font-size: 32px;
            color: #009688;
            margin-bottom: 10px;
        }
        .buttons {
            margin-top: 20px;
            text-align: center;
        }

        .buttons a {
            display: inline-block;
            margin-right: 20px;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #009688;
            color: #fff;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="order-details">
    <h2>訂單詳情</h2>

    <div class="order-info">
        <p><strong>訂單編號：</strong> <?php echo $row['order_id'] ?></p>
        <p><strong>收件人ID：</strong> <?php echo $row['buyer_id'] ?></p>
        <p><strong>寄件人ID：</strong> <?php echo $row['seller_id'] ?></p>
        <p><strong>寄送司機：</strong> <?php echo $row['driver_id'] ?></p>
        <p><strong>收件人：</strong> <?php echo $row['buyer_name'] ?></p>
        <p><strong>收件地址：</strong> <?php echo $row['buyer_address'] ?></p>
        <p><strong>訂單時間：</strong> <?php echo $row['date_time'] ?></p>
    </div>

    <div class="order-status">
        <div class="status-icon">🕒</div>
        <p><strong>訂單狀態：</strong> <?php echo isset($status_descriptions[$row['status_id']]) ? $status_descriptions[$row['status_id']] : '未知狀態';?></p>
    </div>

    <div class="buttons">
        <!-- 返回首頁的按鈕 -->
        <a href="./index.html">返回首頁</a>

        <!-- 重新查詢的按鈕 -->
        <a href="query_order.html">重新查詢</a>
    </div>
</div>
</div>

</body>
</html>

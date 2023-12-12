<?php
$link=require_once "config.php";

$seller_id = $_POST['seller_id'];
$seller_password = $_POST['seller_password'];

if(!$link){
    die( print_r( sqlsrv_errors(), true));
}
$sql = "SELECT seller_name, seller_address FROM seller WHERE seller_id = '$seller_id' and seller_password = '$seller_password'";
$stmt = sqlsrv_query( $link, $sql );
if(!$stmt){
    die( print_r( sqlsrv_errors(), true));
}
if(!sqlsrv_has_rows($stmt)){
    echo '<script>
    alert("登入失敗，請重新輸入登入憑證。"); 
    location.href="./buyer_login.html";
    </script>';
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC ) ) {
    echo $row['seller_name'].$row['seller_address']."<br>";
    session_start();
    $_SESSION["loggedin"] = true;
    $_SESSION["seller_id"] = $seller_id; 
    $_SESSION["seller_name"] = $row["seller_name"];
    $_SESSION["seller_address"] = $row["seller_address"];
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($link);
    header("location: profile_info/seller.php");
    exit();
}
?>
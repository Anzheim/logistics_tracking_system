<?php
$link=require_once "config.php";

$buyer_id = $_POST['buyer_id'];
$buyer_password = $_POST['buyer_password'];

if(!$link){
    die( print_r( sqlsrv_errors(), true));
}
$sql = "SELECT buyer_name, buyer_address FROM buyer where buyer_id = '$buyer_id' and buyer_password = '$buyer_password'";
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
    echo $row['buyer_name'].$row['buyer_address']."<br>";
    session_start();
    $_SESSION["loggedin"] = true;
    $_SESSION["buyer_id"] = $buyer_id;
    $_SESSION["buyer_name"] = $row["buyer_name"];
    $_SESSION["buyer_address"] = $row["buyer_address"];
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($link);
    header("location: profile_info/buyer.php");
    exit();
}
?>
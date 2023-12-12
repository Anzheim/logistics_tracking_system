<?php
$link=require_once "config.php";

$driver_id = $_POST['driver_id'];
$driver_password = $_POST['driver_password'];

if(!$link){
    die( print_r( sqlsrv_errors(), true));
}
$sql = "SELECT driver_name FROM driver WHERE driver_id = '$driver_id' and driver_password = '$driver_password'";
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
    echo $row['driver_name']."<br>";
    session_start();
    $_SESSION["loggedin"] = true;
    $_SESSION["driver_id"] = $driver_id; 
    $_SESSION["driver_name"] = $row["driver_name"];
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($link);
    header("location: profile_info/driver.php");
    exit();
}
?>
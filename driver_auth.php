<?php
$pdo=require_once "config.php";
//var_dump($pdo);

try{

    $driver_id = $_POST['driver_id'];
    $driver_password = $_POST['driver_password'];

    $sql = "SELECT driver_name FROM driver WHERE driver_id = :driver_id AND driver_password = :driver_password";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':driver_id', $driver_id, PDO::PARAM_STR);
    $stmt->bindParam(':driver_password', $driver_password, PDO::PARAM_STR);
    $stmt->EXECUTE();

    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    //var_dump($row);
    if(!$row){
        echo '<script>
            alert("登入失敗，請重新輸入登入憑證。"); 
            location.href="./driver_login.html";
            </script>';
    }else{
        echo $row['driver_name'];
        session_start();
        $_SESSION["loggedin"] = true;
        $_SESSION["driver_id"] = $driver_id;
        $_SESSION["driver_name"] = $row["driver_name"];
        header("location: ./driver.php");
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    echo "PDO error code: " . $e->getCode();
}

$pdo=NULL;

?>

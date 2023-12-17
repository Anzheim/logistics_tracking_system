<?php
$pdo=require_once "config.php";

try{

    $admin_id = $_POST['admin_id'];
    $admin_password = $_POST['admin_password'];

    $sql = "SELECT * FROM administrator WHERE admin_id = :admin_id AND admin_password = :admin_password";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_STR);
    $stmt->bindParam(':admin_password', $admin_password, PDO::PARAM_STR);
    $stmt->EXECUTE();

    $row=$stmt->fetch(PDO::FETCH_ASSOC);

    if(!$row){
        echo '<script>
            alert("登入失敗，請重新輸入登入憑證。"); 
            location.href="./index.html";
            </script>';
    }else{
        echo $row['admin_name'];
        session_start();
        $_SESSION["admin_loggedin"] = true;
        $_SESSION["admin_id"] = $admin_id;
        header("location: ./admin.php");
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    echo "PDO error code: " . $e->getCode();
}

$pdo=NULL;

?>

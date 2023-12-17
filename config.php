<?php
$dsn = "";
$user = "";
$password = "";

try {
    $pdo = new PDO($dsn, $user, $password);
    //echo "PDO connection established.";
    echo "<br>";
    return $pdo;
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    echo "PDO error code: " . $e->getCode();
}

?>


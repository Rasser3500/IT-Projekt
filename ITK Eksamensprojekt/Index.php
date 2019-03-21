<html>
<?php
include"Connect.php";
$sql = "CREATE DATABASE ProductDB";
if ($conn->query($sql) === TRUE) {
    echo "Database created"."<br>";
} else {
    echo $conn->error."<br>";
}

$sql = "CREATE TABLE ProductDB.ProductTable (
ProductID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Name VARCHAR(60) NOT NULL,
Value INT(60) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "ProductTable created "."<br>";
} else {
    echo $conn->error."<br>";
}

$sql = "CREATE TABLE ProductDB.UserTable (
UserID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Name VARCHAR(60) NOT NULL,
Balance INT(60) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "UserTable created"."<br>";
} else {
    echo $conn->error."<br>";
}

$sql = "CREATE TABLE ProductDB.PurchaseTable (
PurchaseID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
UserID INT(60) NOT NULL,
ProductID INT(60) NOT NULL,
Amount INT(60) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "PurchaseTable created"."<br>";
} else {
    echo $conn->error."<br>";
}
    $conn->close();
?>
<a href="homePage.php"><button>Ok</button></a>
</html>

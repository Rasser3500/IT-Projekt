<html>
<?php
include"Connect.php";

$Name = $_GET["Name"];

$sql = "INSERT INTO AdventureDB.PartyTable (PartyName) Value('$Name')";

if ($conn->query($sql) === TRUE) {
    echo "New Party added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
<a href="viewParties.php"><button>Ok</button></a>
</html>
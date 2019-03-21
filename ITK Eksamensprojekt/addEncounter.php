<html>
<?php
include"Connect.php";

$Name = $_GET["Name"];
$CR = $_GET["CR"];

$sql = "INSERT INTO EncounterDB.EncounterTable (Name, CR) Value('$Name', '$CR')";

if ($conn->query($sql) === TRUE) {
    echo "New User added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
<a href="homePage.php"><button>Ok</button></a>
</html>
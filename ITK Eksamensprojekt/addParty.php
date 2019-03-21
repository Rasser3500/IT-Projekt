<html>
<?php
include"Connect.php";

$PartyName = $_GET["PartyName"];

$sql = "INSERT INTO AdventureDB.PartyTable (PartyName) Value('$EncounterName')";

if ($conn->query($sql) === TRUE) {
    echo "New Party added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
<a href="viewEncounters.php"><button>Ok</button></a>
</html>
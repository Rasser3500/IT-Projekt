<html>
<?php
include"Connect.php";

$EncounterName = $_GET["EncounterName"];

$sql = "INSERT INTO AdventureDB.EncounterTable (EncounterName) Value('$EncounterName')";

if ($conn->query($sql) === TRUE) {
    echo "New Encounter added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
<a href="viewEncounters.php"><button>Ok</button></a>
</html>
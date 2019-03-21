<html>
<?php
include"Connect.php";

$EncounterID = $_GET["EncounterID"];
$sql = "DELETE FROM AdventureDB.EncounterTable WHERE EncounterID='$EncounterID'";
if ($conn->query($sql) === TRUE) {
    echo "record removal successfull"."<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
<a href="viewEncounters.php"><button>Ok</button></a>
</html>
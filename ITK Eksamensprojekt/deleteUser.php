<html>
<?php
include"Connect.php";

$UserID = $_GET["EncounterID"];
$sql = "DELETE FROM EncounterDB.EncounterTable WHERE EncounterID='$EncounterID'";
if ($conn->query($sql) === TRUE) {
    echo "record removal successfull"."<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
<a href="homePage.php"><button>Ok</button></a>
</html>

<html>
<?php
include"Connect.php";

$PartyID = $_GET["PartyID"];
$sql = "DELETE FROM AdventureDB.PartyTable WHERE PartyID='$PartyID'";
if ($conn->query($sql) === TRUE) {
    echo "record removal successfull"."<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
<a href="viewParties.php"><button>Ok</button></a>
</html>
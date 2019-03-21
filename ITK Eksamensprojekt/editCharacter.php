<html>
<?php
include"Connect.php";
$CharacterID = $_GET["CharacterID"];
$PartyID = $_GET["PartyID"];
$sql = "DELETE FROM AdventureDB.CharacterTable WHERE CharacterID='$CharacterID'";
if ($conn->query($sql) === TRUE) {
    echo "record removal successfull"."<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
<form action="viewCharacters.php">
    <button type="submit" name="PartyID" value="<?php echo $PartyID; ?>">Ok</button>
</form>
</html>
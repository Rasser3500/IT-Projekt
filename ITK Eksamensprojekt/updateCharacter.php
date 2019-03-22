<html>
<?php
include"Connect.php";
$PartyID = $_GET["PartyID"];
$CharacterID = $_GET["CharacterID"];
$CharacterName = $_GET["CharacterName"];
$EXP = $_GET["EXP"];
$Lvl = $_GET["Lvl"];
$Class = $_GET["Class"];
$Race = $_GET["Race"];

$sql = "UPDATE AdventureDB.CharacterTable SET CharacterName = '$CharacterName', EXP = '$EXP', Lvl = '$Lvl', Class = '$Class', Race = '$Race' WHERE CharacterID='$CharacterID'";

if ($conn->query($sql) === TRUE) {
    echo $CharacterName." edited successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
<form action="viewCharacters.php">
    <button type="submit" name="PartyID" value="<?php echo $PartyID; ?>">Ok</button>
</form>
</html>
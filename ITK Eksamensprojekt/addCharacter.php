<html>
<?php
include"Connect.php";
$PartyID = $_GET["PartyID"];
$CharacterName = $_GET["CharacterName"];
$EXP = $_GET["EXP"];
$Lvl = $_GET["Lvl"];
$Class = $_GET["Class"];
$Race = $_GET["Race"];

$sql = "INSERT INTO AdventureDB.CharacterTable (CharacterName, EXP, Lvl, Class, Race) Value('$CharacterName', '$EXP', '$Lvl', '$Class', '$Race')";

if ($conn->query($sql) === TRUE) {
    echo "New Character added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
<form action="viewCharacters.php">
    <button type="submit" name="PartyID" value="<?php echo $PartyID; ?>">Ok</button>
</form>
</html>
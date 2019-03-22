<html>
<?php       
include"Connect.php";

$PartyID = $_GET["PartyID"];
$CharacterID = $_GET["CharacterID"];
$Member = $_GET["Member"];

$sql = "SELECT PartyName FROM AdventureDB.PartyTable WHERE PartyID='$PartyID'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $PartyName = $row["PartyName"];
    }
}
$sql = "SELECT CharacterName FROM AdventureDB.CharacterTable WHERE CharacterID='$CharacterID'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $CharacterName = $row["CharacterName"];
    }
}
if ($Member==1){$string="joined";}
else {$string="left";}   
$sql = "INSERT INTO AdventureDB.ContractTable (PartyID, CharacterID, Member) Value('$PartyID', '$CharacterID', '$Member')";
if ($conn->query($sql) === TRUE) { echo $CharacterName." has ".$string." ".$PartyName;}
else {echo "Error: " . $sql . "<br>" . $conn->error;}
?>
<form action="viewCharacters.php">
  <button type="submit" name="PartyID" value="<?php echo $PartyID; ?>">Back</button> 
</form>
</html>
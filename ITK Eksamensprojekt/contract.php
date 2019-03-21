<html>
<?php       
include"Connect.php";

$PartyID = $_GET["PartyID"];
$CharacterID = $_GET["CharacterID"];
$Member = $_GET["Member"];
if ($Member==1){$string="joined";}
else {$string="left";}
    
$sql = "INSERT INTO AdventureDB.ContractTable (PartyID, CharacterID, Member) Value('$PartyID', '$CharacterID', '$Member')";
if ($conn->query($sql) === TRUE) { echo $CharacterName."has".$string.$PartyName;}
else {echo "Error: " . $sql . "<br>" . $conn->error;}
?>
<form action="viewCharacters.php">
  <button type="submit" name="PartyID" value="<?php echo $PartyID; ?>">Back</button> 
</form>
</html>
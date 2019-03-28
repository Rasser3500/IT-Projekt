<html>
<?php
include"database.php";
$conn = getConnection();
$PartyID=$_SESSION['PartyID'];
$CharacterID = $_POST["CharacterID"];
$Member = $_POST["Member"];
$PartyName=getName($conn,$PartyID,"Party");
$CharacterName=getName($conn,$CharacterID,"Character");
if ($Member==1){$string="joined";}
else {$string="left";}   
$sql = "INSERT INTO AdventureDB.ContractTable (PartyID, CharacterID, Member) Value('$PartyID', '$CharacterID', '$Member')";
if ($conn->query($sql) === TRUE) { echo $CharacterName." has ".$string." ".$PartyName;}
else {echo "Error: " . $sql . "<br>" . $conn->error;}
?>
<br><br>
<a href="viewCharacters.php"><button>Ok</button></a>
</html>
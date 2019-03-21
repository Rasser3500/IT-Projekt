<html>
<?php
include"Connect.php";
$PartyID = $_GET["PartyID"];
$sql = "SELECT PartyName FROM AdventureDB.PartyTable WHERE PartyID='$PartyID'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo " Contract Characters to " . $row["PartyName"]."<br>";
    }
}

$sql = "SELECT CharacterID, CharacterName, EXP, Lvl, Class, Race FROM AdventureDB.CharacterTable";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo " CharacterName:  " . $row["CharacterName"]."<br>";
        echo " EXP:  " . $row["EXP"]."<br>";
        echo " Lvl:  " . $row["Lvl"]."<br>";
        echo " Class:  " . $row["Class"]."<br>";
        echo " Race:  " . $row["Race"]."<br>";
        ?>
        <form action="Contract.php">
            <input type="Hidden" name="PartyID" value="<?php echo $PartyID ?>">
            <button type="submit" name="CharacterID" value="<?php echo $row["CharacterID"]; ?>">Add Character</button>
        </form>
        <form action="deleteCharacter.php">
            <input type="Hidden" name="PartyID" value="<?php echo $PartyID ?>">
            <button type="submit" name="CharacterID" value="<?php echo $row["CharacterID"]; ?>">Delete Character</button>
        </form>
        <?php
    }
} else {
    echo "<br>"."There are no Characters"."<br>";
}
?>
<form action="newCharacter.php">
   <button type="submit" name="PartyID" value="<?php echo $PartyID; ?>">Create New Character</button>
</form>
<form action="viewMembers.php">
   <button type="submit" name="PartyID" value="<?php echo $PartyID; ?>">Back</button>
</form>
</html>
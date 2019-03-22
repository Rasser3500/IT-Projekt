<html>
<?php
include"Connect.php";
$PartyID = $_GET["PartyID"];
$CharacterID = $_GET["CharacterID"];
$sql = "SELECT CharacterName, EXP, Lvl, Class, Race FROM AdventureDB.CharacterTable WHERE CharacterID = '$CharacterID'";
$result = $conn->query($sql);
if ($result->num_rows != 0) {
    $boolean = true;
    while($row = $result->fetch_assoc()) {
        $CharName=$row["CharacterName"];
        $CharEXP=$row["EXP"];
        $CharLvl=$row["Lvl"];
        $CharClass=$row["Class"];
        $CharRace=$row["Race"];
    }
}
?>
<form action=" updateCharacter.php">
    Name:<br>
    <input type="text" name="CharacterName" value="<?php echo$CharName; ?>">
    <br>
    EXP:<br>
    <input type="text" name="EXP" value="<?php echo$CharEXP; ?>">
    <br>
    Lvl:<br>
    <input type="text" name="Lvl" value="<?php echo$CharLvl; ?>">
    <br>
    Class:<br>
    <input type="text" name="Class" value="<?php echo$CharClass; ?>">
    <br>
    Race:<br>
    <input type="text" name="Race" value="<?php echo$CharRace; ?>">
    <br>
    <input type="Hidden" name="CharacterID" value="<?php echo $CharacterID ?>">
    <br>
    <button type="submit" name="PartyID" value="<?php echo $PartyID; ?>">Update Character</button>
</form>
<form action="viewCharacters.php">
    <button type="submit" name="PartyID" value="<?php echo $PartyID; ?>">Back</button>
</form>
</html>

<html>
<?php
include"Connect.php";
$PartyID = $_GET["PartyID"];
?>
<form action="addCharacter.php">
    Name:<br>
    <input type="text" name="CharacterName" value="">
    <br>
    EXP:<br>
    <input type="text" name="EXP" value="">
    <br>
    Lvl:<br>
    <input type="text" name="Lvl" value="">
    <br>
    Class:<br>
    <input type="text" name="Class" value="">
    <br>
    Race:<br>
    <input type="text" name="Race" value="">
    <br><br>
    <button type="submit" name="PartyID" value="<?php echo $PartyID; ?>">Create Character</button>
</form>
</html>

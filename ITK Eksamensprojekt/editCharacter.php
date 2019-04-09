<html>
<?php
include"database.php";
$conn=getConnection();
$CharacterID=isset($_POST["CharacterID"])?$_POST["CharacterID"]:0;
error_reporting(E_ERROR | E_PARSE);
$Info=[][""];
if ($CharacterID!=0){
    $Info[1][0]=$CharacterID;
    $Info=getCharacterInfo($conn,1,$Info);
}
?>
<form action=" updateCharacter.php" method="post">
    Name:<br>
    <input type="text" name="Name" value="<?php echo $Info[1][2]; ?>">
    <br>
    EXP:<br>
    <input type="text" name="EXP" value="<?php echo $Info[1][3]; ?>">
    <br>
    Lvl:<br>
    <input type="text" name="Lvl" value="<?php echo $Info[1][4]; ?>">
    <br>
    Class:<br>
    <input type="text" name="Class" value="<?php echo $Info[1][5]; ?>">
    <br>
    Race:<br>
    <input type="text" name="Race" value="<?php echo $Info[1][6]; ?>">
    <br>
    <button type="submit" name="CharacterID" value="<?php echo $CharacterID ?>">Next</button>
</form>
<br>
<a href="viewCharacters.php"><button>Back</button></a>
</html>
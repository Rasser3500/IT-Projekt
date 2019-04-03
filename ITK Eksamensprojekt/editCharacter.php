<html>
<?php
include"database.php";
$conn=getConnection();
$CharacterID=isset($_POST["CharacterID"])?$_POST["CharacterID"]:0;
error_reporting(E_ERROR | E_PARSE);
$CharInfo=[][""];
if ($CharacterID!=0){
    $CharInfo=getCharInfo($conn,$CharacterID,"Character",$CharInfo);
}
?>
<form action=" updateCharacter.php" method="post">
    Name:<br>
    <input type="text" name="Name" value="<?php echo $CharInfo[$CharacterID][1]; ?>">
    <br>
    EXP:<br>
    <input type="text" name="EXP" value="<?php echo $CharInfo[$CharacterID][2]; ?>">
    <br>
    Lvl:<br>
    <input type="text" name="Lvl" value="<?php echo $CharInfo[$CharacterID][3]; ?>">
    <br>
    Class:<br>
    <input type="text" name="Class" value="<?php echo $CharInfo[$CharacterID][4]; ?>">
    <br>
    Race:<br>
    <input type="text" name="Race" value="<?php echo $CharInfo[$CharacterID][5]; ?>">
    <br>
    <button type="submit" name="CharacterID" value="<?php echo $CharacterID ?>">Next</button>
</form>
<br>
<a href="viewCharacters.php"><button>Back</button></a>
</html>
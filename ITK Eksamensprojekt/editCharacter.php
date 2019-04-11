<html>
<?php
include"database.php";
$conn=getConnection();
$CharacterID=isset($_POST["CharacterID"])?$_POST["CharacterID"]:0;
error_reporting(E_ERROR | E_PARSE);
$Home=isset($_POST["Home"])?$_POST["Home"]:"Character";
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
    Lvl:<br>
    <input type="text" name="Lvl" value="<?php echo $Info[1][3]; ?>">
    <br>
    Exp:<br>
    <input type="text" name="EXP" value="<?php echo $Info[1][4]-getCharExp($Info[1][3]); ?>">
    <br>
    Class:<br>
    <input type="text" name="Class" value="<?php echo $Info[1][5]; ?>">
    <br>
    Race:<br>
    <input type="text" name="Race" value="<?php echo $Info[1][6]; ?>">
    <br>
    <input type="hidden" name="Home" value="<?php echo $Home; ?>" >
    <button type="submit" name="CharacterID" value="<?php echo $CharacterID ?>">Next</button>
</form>
<br>
<a href="<?php echo "view".$Home."s.php" ?>"><button>Back</button></a>
</html>
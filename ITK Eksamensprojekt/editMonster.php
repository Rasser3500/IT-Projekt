<html>
<!-- der bliver refreret til stylesheetet-->
<link rel="stylesheet" type="text/css" href="stylesheet.css" />
<?php
include"database.php";
$conn=getConnection();
$MonsterID=isset($_POST["MonsterID"])?$_POST["MonsterID"]:0;
$Home=isset($_POST["Home"])?$_POST["Home"]:"Monster";
$Info=[][""];
if ($MonsterID!=0){
    $Info[1][0]=$MonsterID;
    $Info=getMonsterInfo($conn,1,$Info);
}
?>
<form action=" updateMonster.php" method="post">
    Name:<br>
    <input type="text" name="Name" value="<?php echo $Info[1][2]; ?>">
    <br>
    Size:<br>
    <input type="text" name="Size" value="<?php echo $Info[1][3]; ?>">
    <br>
    Cr:<br>
    <input type="text" name="Cr" value="<?php echo $Info[1][4]; ?>">
    <br>
    Alignment:<br>
    <input type="text" name="Alignment" value="<?php echo $Info[1][5]; ?>">
    <br>
    Type:<br>
    <input type="text" name="Type" value="<?php echo $Info[1][6]; ?>">
    <br>
    <input type="hidden" name="Home" value="<?php echo $Home; ?>" >
    <button type="submit" name="MonsterID" value="<?php echo $MonsterID ?>">Next</button>
</form>
<br>
<a href="<?php echo "view".$Home."s.php" ?>"><button>Back</button></a>
</html>
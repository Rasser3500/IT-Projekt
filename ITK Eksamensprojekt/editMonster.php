<html>
<?php
include"database.php";
$conn=getConnection();
$MonsterID=isset($_POST["MonsterID"])?$_POST["MonsterID"]:0;
error_reporting(E_ERROR | E_PARSE);
$CharInfo=[][""];
if ($MonsterID!=0){
    $CharInfo=getCharInfo($conn,$MonsterID,"Monster",$CharInfo);
}
?>
<form action=" updateMonster.php" method="post">
    Name:<br>
    <input type="text" name="Name" value="<?php echo $CharInfo[$MonsterID][1]; ?>">
    <br>
    Size:<br>
    <input type="text" name="Size" value="<?php echo $CharInfo[$MonsterID][2]; ?>">
    <br>
    Cr:<br>
    <input type="text" name="Cr" value="<?php echo $CharInfo[$MonsterID][3]; ?>">
    <br>
    Alignment:<br>
    <input type="text" name="Alignment" value="<?php echo $CharInfo[$MonsterID][4]; ?>">
    <br>
    Type:<br>
    <input type="text" name="Type" value="<?php echo $CharInfo[$MonsterID][5]; ?>">
    <br>
    <button type="submit" name="MonsterID" value="<?php echo $MonsterID ?>">Next</button>
</form>
<br>
<a href="viewMonsters.php"><button>Back</button></a>
</html>
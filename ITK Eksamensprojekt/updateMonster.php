<html>
<?php
include"database.php";
$conn=getConnection();
$MonsterID=isset($_POST["MonsterID"])?$_POST["MonsterID"]:0;
if ($MonsterID==0){
    if(createMonster($conn,$_POST["Name"],$_POST["Size"],$_POST["Cr"],$_POST["Alignment"],$_POST["Type"])){
        echo $_POST["Name"]." was created";
    }  
} else {
    if(updateMonster($conn,$MonsterID,$_POST["Name"],$_POST["Size"],$_POST["Cr"],$_POST["Alignment"],$_POST["Type"])){
        echo $_POST["Name"]." was updated";
    }  
}


?>
<br>
<a href="viewMonsters.php"><button>Ok</button></a>
</html>
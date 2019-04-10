<html>
<?php
include"database.php";
$conn=getConnection();
$CharacterID=isset($_POST["CharacterID"])?$_POST["CharacterID"]:0;
if ($CharacterID==0){
    if(createCharacter($conn,$_POST["Name"],$_POST["EXP"]+getCharExp($_POST["Lvl"]),$_POST["Class"],$_POST["Race"])){
        echo $_POST["Name"]." was created";
    }  
} else {
    if(updateCharacter($conn,$CharacterID,$_POST["Name"],$_POST["EXP"]+getCharExp($_POST["Lvl"]),$_POST["Class"],$_POST["Race"])){
        echo $_POST["Name"]." was updated";
    }  
}


?>
<br>
<a href="viewCharacters.php"><button>Ok</button></a>
</html>
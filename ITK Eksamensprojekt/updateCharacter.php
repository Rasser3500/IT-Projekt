<html>
<?php
include"database.php";
$conn=getConnection();
$CharacterID=isset($_POST["CharacterID"])?$_POST["CharacterID"]:0;
echo $CharacterID;
if ($CharacterID==0){
    if(createCharacter($conn,$_POST["Name"],$_POST["EXP"],$_POST["Lvl"],$_POST["Class"],$_POST["Race"])){
        echo $_POST["Name"]." was created";
    }  
} else {
    if(updateCharacter($conn,$CharacterID,$_POST["Name"],$_POST["EXP"],$_POST["Lvl"],$_POST["Class"],$_POST["Race"])){
        echo $_POST["Name"]." was updated";
    }  
}


?>
<form action="viewCharacters.php">
    <button type="submit" name="PartyID" value="<?php echo $PartyID; ?>">Ok</button>
</form>
</html>
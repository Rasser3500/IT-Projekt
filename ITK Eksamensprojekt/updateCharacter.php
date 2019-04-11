<html>
<!-- der bliver refreret til stylesheetet-->
<link rel="stylesheet" type="text/css" href="stylesheet.css" />
<?php
//inkludere databasens funktioner og for connection
include"database.php";
$conn=getConnection();
//tjekker om det givende CharacterID er ligmed 0
if ($_POST["CharacterID"]==0){
    //hvis ja bliver informationerne sent med funktionen for at lave en character
    if(createCharacter($conn,$_POST["Name"],$_POST["EXP"]+getCharExp($_POST["Lvl"]),$_POST["Class"],$_POST["Race"])){
        //skriver navnet på charcteren
        echo $_POST["Name"]." was created";
    }  
} else {
   //hvis nej bliver informationenerne sent med funktionen til at ændre på characteren med det givende characterID
    if(updateCharacter($conn,$_POST["CharacterID"],$_POST["Name"],$_POST["EXP"]+getCharExp($_POST["Lvl"]),$_POST["Class"],$_POST["Race"])){
        echo $_POST["Name"]." was updated";
    }  
}


?>
<!--laver en knap baseret på Home værdigen -->
<br>
<a href="<?php echo "view".$_POST["Home"]."s.php" ?>"><button>Ok</button></a>
</html>
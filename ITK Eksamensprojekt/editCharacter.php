<html>
<?php
//inkludere databasens funktioner og for connection
include"database.php";
$conn=getConnection();
//Henter chekker om den kan få Character IDet gennem POST, hvis ja tager den det, hvis ikke sætter den det til 0
$CharacterID=isset($_POST["CharacterID"])?$_POST["CharacterID"]:0;
//Henter chekker om den kan få Home gennem POST, hvis ja tager den det, hvis ikke sætter den det til "Character"
$Home=isset($_POST["Home"])?$_POST["Home"]:"Character";
//laver et array og sætter den til ikke at skrive noget
$Info=[][""];
//hvis der er givent et CharacterID bliver array fylt med info
if ($CharacterID!=0){
    $Info[1][0]=$CharacterID;
    $Info=getCharacterInfo($conn,1,$Info);
}
?>
<!--laver textfælter hvor der kan skrives hvad Navn, Lvl, Exp, Class og Race skal være, hvor start værdigerne er bestemt ud fra Info arrayet, samt en knap som submiter værdigerne og CharacterIDet-->
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
<!--laver en knap til bage baseret på home værdien --> 
<a href="<?php echo "view".$Home."s.php" ?>"><button>Back</button></a>
</html>
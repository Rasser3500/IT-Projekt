<html>
<!-- der bliver refreret til stylesheetet-->
<link rel="stylesheet" type="text/css" href="stylesheet.css" />
<!-- h1 startes-->
<h1>
<?php
//inkludere databasens funktioner og får connection
include"database.php";
$conn = getConnection();
//rester PartyID fra session og henter EncounterId fra session hvis den ikke kan fåes gennem POST
$_SESSION['PartyID']=0;
$_SESSION['EncounterID']=isset($_POST['EncounterID'])?$_POST['EncounterID']:$_SESSION['EncounterID'];
//skriver titlen til siden
echo "List of Parties<br></h1>";
//finder alle partyIDerne og sætter dem i et array, hvor de kan findes som den 0'de information til et nummeret
$GroupInfo=getID($conn,"Party");
//kører et forloop udfra hvormange PartyIDer der blev fundet.
for($i=1; $i<sizeof($GroupInfo)+1; $i++){
    //skriver det tilhørende navn til partyIdet vedhjælp af getName funktionen 
    echo "<h2>",getName($conn,$GroupInfo[$i][0],"Party"),"</h2>";
    echo "Party lvls: ";
    //finder alle CharacterIDerne og sætter dem i et nyt array, hvor de kan findes som den 0'de information til et nummeret
    $CharInfo=getID($conn,"Character");
    //kører et forloop udfra hvormange CharacterIDer der blev fundet.
    for($j=1; $j<sizeof($CharInfo)+1; $j++){
        //finder hvorvidt characteren har en contract med partyIDet og sætter det i character arrayet til 1
        $CharInfo[$j][1]=getAmount($conn,$CharInfo[$j][0],$GroupInfo[$i][0],"Party");
        //finder alt andet information omkring characteren og kommer det i arrayet
        $CharInfo=getCharacterInfo($conn,$j,$CharInfo);
        //skriver characterens Lvl hvis den har en contract med partiet
        if($CharInfo[$j][1] > 0){echo $CharInfo[$j][3]." ";}
    }
	echo"<br>";
    //laver en knap til at submit dette partyID med til lengend siden, hvis der er blevet givent et encounterID 
    if ($_SESSION['EncounterID']!=0){
        ?>
        <form action="legend.php" method="post">
            <input type="Hidden" name="Group" value="Encounter">
            <button type="submit" name="PartyID" value="<?php echo $GroupInfo[$i][0]; ?>">Fight Party</button>
        </form>
        <?php
    //ellers laves der en knap til submit dette partyID med til Encounter siden
    }else{
        ?>
        <form action="viewEncounters.php" method="post">     
        <button type="submit" name="PartyID" value="<?php echo $GroupInfo[$i][0]; ?>">Pick Encounter</button>
        </form>
        <?php
    }
    ?>
    <!--laver en knap til at submit dette partyId med til viewMembers siden-->
    <form action="viewMembers.php" method="post">     
        <button type="submit" name="PartyID" value="<?php echo $GroupInfo[$i][0]; ?>">View Members</button>
    </form>
    <!--laver en knap til at submit dette partyId med til delete group siden, samt en hidden var med stringen "Party" -->
    <form action="deleteGroup.php" method="post">
        <input type="Hidden" name="Var" value="Party">
        <button type="submit" name="ID" value="<?php echo $GroupInfo[$i][0]; ?>">Delete Party</button>
    </form>
    <?php
}
?>
<br><br><br>
<!--laver en knap til at submit stringen "Party" til newGroup siden-->
<form action="newGroup.php" method="post">     
    <button type="submit" name="Var" value="Party">Create Party</button>
</form>
<!--laver en knap til homepage-->
<a href="homePage.php"><button>Back</button></a>
</html>
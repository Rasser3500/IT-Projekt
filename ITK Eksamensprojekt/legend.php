<html>
<?php
//inkludere databasens funktioner og får connection
include"database.php";
$conn = getConnection();
//Henter EncounterId og PartyID fra session hvis de ikke kan fåes gennem POST
$PartyID=isset($_POST['PartyID'])?$_POST['PartyID']:$_SESSION['PartyID'];
$EncounterID=isset($_POST['EncounterID'])?$_POST['EncounterID']:$_SESSION['EncounterID'];
//sætter variablen group til at være æigmed gruppe typen
$Group=$_POST['Group'];
//sætter Encounter og Gruppe IDerne ind i LegendTabelen for at laven en ny legend
$sql = "INSERT INTO AdventureDB.LegendTable (PartyID, EncounterID) Value('$PartyID', '$EncounterID')";
//hvis det skete skrives Party and Encounter navne
if ($conn->query($sql) === TRUE) {echo getName($conn,$PartyID,"Party")." has fought ".getName($conn,$EncounterID,"Encounter")."<br>";}
//eller skrives der fejlen
else {echo "Error: " . $sql . "<br>" . $conn->error;}
//laver to inter og sætter dem til 0
$MonsAmountTotal=0;
$ExpTotal=0;
//finder alle MonsterIDerne og sætter dem i et array, hvor de kan findes som den 0'de information til et nummeret
$MonsInfo=getID($conn,"Monster");
//kører et forloop udfra hvormange MonsterIDer der blev fundet. 
for($i=1; $i<sizeof($MonsInfo)+1; $i++){
    //finder hvorvidt monsteren har en contract med EncounterIDet og sætter det i monster arrayet til 1
    $MonsInfo[$i][1]=getAmount($conn,$MonsInfo[$i][0],$EncounterID,"Encounter");
    //finder alt andet information omkring monsteret og kommer det i arrayet
    $MonsInfo=getMonsterInfo($conn,$MonsInfo[$i][0],$MonsInfo);
    //opsumere den totale mængde af monstre i encounteret samt hvor meget exp det hele vil give
    $MonsAmountTotal+=$MonsInfo[$i][1];
    $ExpTotal+=$MonsInfo[$i][7]*$MonsInfo[$i][1];
}
//laver en int og sætter den til 0
$CharAmountTotal=0;
//finder alle CharacterIDerne og sætter dem i et nyt array, hvor de kan findes som den 0'de information til et nummeret
$CharInfo=getID($conn,"Character");
//kører et forloop udfra hvormange CharacterIDer der blev fundet.
for($i=1; $i<sizeof($CharInfo)+1; $i++){
    //finder hvorvidt characteren har en contract med partyIDet og sætter det i character arrayet til 1
    $CharInfo[$i][1]=getAmount($conn,$CharInfo[$i][0],$PartyID,"Party");
    //finder alt andet information omkring characteren og kommer det i arrayet
    $CharInfo=getCharacterInfo($conn,$i,$CharInfo);
    //opsumere den totale mængde af character som har en contract med partiet
    if($CharInfo[$i][1]>0){$CharAmountTotal+=1;}
}
//udregner det gennemsnitlige exp hver charcter skal gives
$AvgExp=($ExpTotal*getMulti($MonsAmountTotal))/$CharAmountTotal;
//kører et forloop udfra hvormange CharacterIDer der er
for($i=1; $i<sizeof($CharInfo)+1; $i++){
    //Character idet bliver sprunget over hvis den ikke har en contract med partyIDet
    if($CharInfo[$i][1]>0){
        //den ny mængde exp characteren har bliver udregnet og sat ind i basen hvor charactetens ID er i charactertabelen
        $NewExp=$AvgExp+$CharInfo[$i][4];
        $CharacterID=$CharInfo[$i][0];
        $sql = "UPDATE AdventureDB.CharacterTable SET EXP = '$NewExp' WHERE CharacterID = '$CharacterID'";
        if ($conn->query($sql) === TRUE) {}
        else {echo "Error: " . $sql . "<br>" . $conn->error;}
    }
}
//der skrives den gennemsnitlige exp
echo "and have each gained ".$AvgExp." Exp";
?>
<br><br>
<!--laver en knap som føre til den givende gruppes side-->
<a href="<?php echo "view".$Group."s.php" ?>"><button>Ok</button></a>
</html>
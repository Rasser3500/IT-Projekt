<html>
<?php
//inkludere databasens funktioner og får connection
include"database.php";
$conn = getConnection();
//rester EncounterID fra session og henter PartyId fra session hvis den ikke kan fåes gennem POST
$_SESSION['EncounterID']=0;
$_SESSION['PartyID']=isset($_POST['PartyID'])?$_POST['PartyID']:$_SESSION['PartyID'];
//skriver titlen til siden
echo "List of Encounters<br><br>";
//finder alle EncounterIDerne og sætter dem i et array, hvor de kan findes som den 0'de information til et nummeret
$GroupInfo=getID($conn,"Encounter");
//kører et forloop udfra hvormange EncounterIDer der blev fundet.
for($i=1; $i<sizeof($GroupInfo)+1; $i++){
    //skriver det tilhørende navn til EncounterIdet vedhjælp af getName funktionen 
    echo getName($conn,$GroupInfo[$i][0],"Encounter")."<br>";
    //laver to inter og sætter dem til 0
    $AmountTotal=0;
    $ExpTotal=0;
    //finder alle MonsterIDerne og sætter dem i et nyt array, hvor de kan findes som den 0'de information til et nummeret
    $CharInfo=getID($conn,"Monster");
    //kører et forloop udfra hvormange MonsterIDer der blev fundet.
    for($j=1; $j<sizeof($CharInfo)+1; $j++){
        //finder hvorvidt monsteren har en contract med EncounterIDet og sætter det i monster arrayet til 1
        $CharInfo[$j][1]=getAmount($conn,$CharInfo[$j][0],$GroupInfo[$i][0],"Encounter");
        //finder alt andet information omkring monsteret og kommer det i arrayet
        $CharInfo=getMonsterInfo($conn,$CharInfo[$j][0],$CharInfo);
        //opsumere den totale mængde af monstre i encounteret samt hvor meget exp det hele vil give
        $AmountTotal+=$CharInfo[$j][1];
        $ExpTotal+=$CharInfo[$j][7]*$CharInfo[$j][1];
    }
    //finder den aktuelle exp ved at gange den totale exp med multiplieren fundet ved hjælp af den totale mængde monstre i encounteret
    echo "Total exp: ".$ExpTotal*getMulti($AmountTotal)." <br><br>";
    //laver en knap til at submit dette encounterID med til lengend siden, hvis der er blevet givent et partyID 
    if ($_SESSION['PartyID']!=0){
        ?>
        <form action="legend.php" method="post">
            <input type="Hidden" name="Group" value="Party">
            <button type="submit" name="EncounterID" value="<?php echo $GroupInfo[$i][0]; ?>">Fight Encounter</button>
        </form>
        <?php
    //ellers laves der en knap til submit dette EncounterID med til Party siden
    }else{
        ?>
        <form action="viewPartys.php" method="post">     
        <button type="submit" name="EncounterID" value="<?php echo $GroupInfo[$i][0]; ?>">Pick Party</button>
        </form>
        <?php
    }
    ?>
    <!--laver en knap til at submit dette EncounterId med til viewMinions siden-->
    <form action="viewMinions.php" method="post">     
        <button type="submit" name="EncounterID" value="<?php echo $GroupInfo[$i][0]; ?>">View Minions</button>
    </form>
    <!--laver en knap til at submit dette EncounterId med til delete group siden, samt en hidden var med stringen "Encounter" -->
    <form action="deleteGroup.php" method="post">
        <input type="Hidden" name="Var" value="Encounter">
        <button type="submit" name="ID" value="<?php echo $GroupInfo[$i][0]; ?>">Delete Encounter</button>
    </form> 
    <?php
    
}
?>
<br>
<!--laver en knap til at submit stringen "Encounter" til newGroup siden-->
<form action="newGroup.php" method="post">     
    <button type="submit" name="Var" value="Encounter">Create Encounter</button>
</form>
<!--laver en knap til homepage-->
<a href="homePage.php"><button>Back</button></a>
</html>

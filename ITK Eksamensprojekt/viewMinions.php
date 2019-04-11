<html>
<?php
//inkludere databasens funktioner og for connection
include"database.php";
$conn = getConnection();
//henter EncounterId fra session hvis den ikke kan fåes gennem POST, og sætter EncounterIDet i sessionen til at være lig det
$EncounterID=isset($_POST['EncounterID'])?$_POST['EncounterID']:$_SESSION['EncounterID'];
$_SESSION['EncounterID']=$EncounterID;
//finder navnet til EncounterIDet og skriver det
echo "Minions of ".getName($conn,$EncounterID,"Encounter")."<br>";
//laver to inter og sætter dem til 0
$AmountTotal=0;
$ExpTotal=0;
//finder alle MonsterIDerne og sætter dem i et array, hvor de kan findes som den 0'de information til et nummeret
$Info=getID($conn,"Monster");
//kører et forloop udfra hvormange MonsterIDer der blev fundet. 
for($i=1; $i<sizeof($Info)+1; $i++){
    //finder hvorvidt monsteren har en contract med EncounterIDet og sætter det i monster arrayet til 1
    $Info[$i][1]=getAmount($conn,$Info[$i][0],$EncounterID,"Encounter");
    //finder alt andet information omkring monsteret og kommer det i arrayet
    $Info=getMonsterInfo($conn,$Info[$i][0],$Info);
    //opsumere den totale mængde af monstre i encounteret samt hvor meget exp det hele vil give
    $AmountTotal+=$Info[$i][1];
    $ExpTotal+=$Info[$i][7]*$Info[$i][1];
}
//finder den aktuelle exp ved at gange den totale exp med multiplieren fundet ved hjælp af den totale mængde monstre i encounteret
echo "Total exp of encounter: ".$ExpTotal*getMulti($AmountTotal)." <br><br>";
//laver en varianble som sætter den lig falsk
$boolean = false;
//kører et forloop udfra mængden af MonsterIDer
for($i=1; $i<sizeof($Info)+1; $i++) {
    //MonsterIDet bliver sprunget over hvis den ikke har en contract med EncounterIDet
    if($Info[$i][1] > 0){
        //hvis der er mindst et monster som har en contract bliver booleanen sat sandt
        $boolean = true;
        ?>
        <!--Laver en tabel i html som skriver den fundede information-->
        <table style="background-color:#875f43;width:40%;table-layout:fixed" border="3">
            <tr>
                <th>Amount</th>
                <th>Name</th>
                <th>Size</th>
                <th>Cr</th>
                <th>Aligment</th>
                <th>Type</th>
                <th>Worth</th>
            </tr>
            <tr>
                <td><?php echo $Info[$i][1];?></td>
                <td><?php echo $Info[$i][2];?></td>
                <td><?php echo $Info[$i][3];?></td>
                <td><?php echo $Info[$i][4];?></td>
                <td><?php echo $Info[$i][5];?></td>
                <td><?php echo $Info[$i][6];?></td>
                <td><?php echo $Info[$i][7]*$Info[$i][1];?></td>
            </tr>
        </table>
        <!--laver en tabel over de forskellige knapper til monsteret-->
        <table>
            <!--der bliver lavet en knap til contract siden, som submiter MonsterIDet, Home er lig true, og at mængden der skal fjernes hvilket er bestem ud fra tekstfæltet -->
            <td><form action="contract.php" method="post">
                <input type="text" name="Amount">
                <input type="hidden" name="Home" value="True">
                <button type="submit" name="CharID" value="<?php echo $Info[$i][0] ?>">Remove Monster</button>
            </form></td>
            <!--der bliver lavet en knap til editMonster siden, hvor der bliver submitet monsterIDet og at Home er lig Minion-->
            <td><form action="editMonster.php" method="post">
                <input type="hidden" name="Home" value="Minion">
                <button type="submit" name="MonsterID" value="<?php echo $Info[$i][0] ?>">Edit Monster</button>
            </form></td>
        </table>
        <?php
    }
}
//Hvis booleanen ikke blev sat sandt, bliver skrevet der ikke var nogle monstre
if ($boolean==false){echo "There are no Monsters";}
//der bliver lavet knaper til at se monsterne, og til at gå tilbage til at se Encounterne
?>
<a href="viewMonsters.php"><button>Contract Monsters</button></a>
<br><br>
<a href="viewEncounters.php"><button>Back</button></a>
</html>
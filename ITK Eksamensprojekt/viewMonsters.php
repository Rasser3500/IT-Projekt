<html>
<!-- der bliver refreret til stylesheetet-->
<link rel="stylesheet" type="text/css" href="stylesheet.css" />
<?php
//inkludere databasens funktioner og får connection samt EncounterIDet fra sessionen
include"database.php";
$conn = getConnection();
$EncounterID=$_SESSION['EncounterID'];
//Navnet til EncounterIDet bliver fundet og skrevet
echo "Contract Monsters to ".getName($conn,$EncounterID,"Encounter")."<br><br>";
//finder alle MonsterIDerne og sætter dem i et array, hvor de kan findes som den 0'de information til et nummeret
$Info=getID($conn,"Monster");
//kører et forloop udfra hvormange MonsterIDer der blev fundet. 
for($i=1; $i<sizeof($Info)+1; $i++){
        //finder hvorvidt monsteren har en contract med EncounterIDet og sætter det i monster arrayet til 1
        $Info[$i][1]=getAmount($conn,$Info[$i][0],$EncounterID,"Encounter");
        //finder alt andet information omkring monsteret og kommer det i arrayet
        $Info=getMonsterInfo($conn,$i,$Info);    
}
//laver en varianble som sætter den lig falsk
$boolean = false;
//kører et forloop udfra mængden af MonsterIDer
for($i=1; $i<sizeof($Info)+1; $i++) {
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
        </tr>
        <tr>
            <td><?php echo $Info[$i][1];?></td>
            <td><?php echo $Info[$i][2];?></td>
            <td><?php echo $Info[$i][3];?></td>
            <td><?php echo $Info[$i][4];?></td>
            <td><?php echo $Info[$i][5];?></td>
            <td><?php echo $Info[$i][6];?></td>
        </tr>
    </table>
    <!--laver en tabel over de forskellige knapper til monsteret-->
    <table style="background-color:#a08f70;width:40%;table-layout:auto" border="3">
        <!--der bliver lavet en knap til contract siden, som submiter MonsterIDet og at mængden der skal tilføjes hvilket er bestem ud fra tekstfæltet -->
        <td><form action="contract.php" method="post">
            <input type="Text" name="Amount" size="1">
            <button type="submit" name="CharID" value="<?php echo $Info[$i][0] ?>">Add Monster</button>
        </form></td>
        <!--der bliver lavet en knap til editMonster siden, hvor der bliver submitet monsterIDet-->
        <td><form action="editMonster.php" method="post">
            <button type="submit" name="MonsterID" value="<?php echo $Info[$i][0] ?>">Edit Monster</button>
        </form></td>
        <td><form action="deleteGroup.php" method="post">
            <input type="Hidden" name="Var" value="Monster">
            <button type="submit" name="ID" value="<?php echo $Info[$i][0]; ?>">Delete Monster</button>
        </form></td>
	</table>
    <?php
}
//Hvis booleanen ikke blev sat sandt, bliver skrevet der ikke var nogle monstre
if ($boolean==false){echo "There are no Monsters";}
//der bliver lavet knaper til lave nye monstre, og til at gå tilbage til at se Minions
?>
<a href="editMonster.php"><button>Create New Monster</button></a>
<br><br>
<a href="viewMinions.php"><button>Back</button></a>
</html>
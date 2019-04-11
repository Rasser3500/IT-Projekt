<html>
<?php
//inkludere databasens funktioner og for connection
include"database.php";
$conn = getConnection();
//henter partyId fra session hvis den ikke kan fåes gennem POST, og sætter partyIDet i sessionen til at være lig det
$PartyID=isset($_POST['PartyID'])?$_POST['PartyID']:$_SESSION['PartyID'];
$_SESSION['PartyID']=$PartyID;
//finder navnet til PartyIDet ud skriver det
echo "Members of ".getName($conn,$PartyID,"Party")."<br><br>";
//finder alle CharacterIDerne og sætter dem i et nyt array, hvor de kan findes som den 0'de information til et nummeret
$Info=getID($conn,"Character");
//kører et forloop udfra hvormange CharacterIDer der blev fundet. 
for($i=1; $i<sizeof($Info)+1; $i++){
    //finder hvorvidt characteren har en contract med partyIDet og sætter det i character arrayet til 1
    $Info[$i][1]=getAmount($conn,$Info[$i][0],$PartyID,"Party");
    //finder alt andet information omkring characteren og kommer det i arrayet
    $Info=getCharacterInfo($conn,$i,$Info);    
}
//laver en varianble som sætter den lig falsk
$boolean = false;
//kører et forloop udfra mængden af CharacterIDer
for($i=1; $i<sizeof($Info)+1; $i++) {
    //Character idet bliver sprunget over hvis den ikke har en contract med partyIDet
    if($Info[$i][1] > 0){
        //hvis der er mindst en character som har en contract bliver booleanen sat sandt
        $boolean = true;
        ?>
        <!--Laver en tabel i html som skriver den fundede information-->
        <table style="background-color:#875f43;width:40%;table-layout:fixed" border="3">
            <tr>
                <th>Name</th>
                <th>Lvl</th>
                <th>Exp</th>
                <th>Class</th>
                <th>Race</th>
            </tr>
            <tr>
                <td><?php echo $Info[$i][2];?></td>
                <td><?php echo $Info[$i][3];?></td>
                <td><?php echo $Info[$i][4]-getCharExp($Info[$i][3]);?></td>
                <td><?php echo $Info[$i][5];?></td>
                <td><?php echo $Info[$i][6];?></td>
            </tr>
        </table>
        <!--laver en tabel over de forskellige knapper til caracteren-->
        <table>
            <!--der bliver lavet en knap til contract siden, som submiter characterIDet, Home er lig true, og at mængden der skal fjernes hvilket alttid 1-->
            <td><form action="contract.php" method="post">
                <input type="Hidden" name="CharID" value="<?php echo $Info[$i][0] ?>">
                <input type="hidden" name="Home" value="True">
                <button type="submit" name="Amount" value="1">Remove from Party</button>
            </form></td>
            <!--der bliver lavet en knap til editCharacter siden, hvor der bliver submitet characterIDet og at Home er lig Member-->
            <td><form action="editCharacter.php" method="post">
                <input type="hidden" name="Home" value="Member">
                <button type="submit" name="CharacterID" value="<?php echo $Info[$i][0] ?>">Edit Character</button>
            </form></td>
        </table>
        <?php
    }
}
//Hvis booleanen ikke blev sat sandt, bliver skrevet der ikke var nogle charactere
if ($boolean==false){echo "There are no Characters";}
//der bliver lavet knaper til at se charactere, og til at gå tilbage til at se Partierne
?>
<a href="viewCharacters.php"><button>Contract Characters</button></a>
<br><br>
<a href="viewPartys.php"><button>Back</button></a>
</html>
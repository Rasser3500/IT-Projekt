<html>
<!-- der bliver refreret til stylesheetet-->
<link rel="stylesheet" type="text/css" href="stylesheet.css" />
<!-- h1 startes-->
<h1>
<?php
//inkludere databasens funktioner og får connection samt PartyIDet fra sessionen
include"database.php";
$conn = getConnection();
$PartyID=$_SESSION['PartyID'];
//Navnet til partyIDet bliver fundet og skrevet
echo "Contract Characters to ".getName($conn,$PartyID,"Party")."<br>";
//finder alle CharacterIDerne og sætter dem i et nyt array, hvor de kan findes som den 0'de information til et nummeret
$Info=getID($conn,"Character");
//kører et forloop udfra hvormange CharacterIDer der blev fundet. 
for($i=1; $i<sizeof($Info)+1; $i++){
    //finder hvorvidt characteren har en contract med partyIDet og sætter det i character arrayet til 1
    $Info[$i][1]=getAmount($conn,$Info[$i][0],$PartyID,"Party");
    //finder alt andet information omkring characteren og kommer det i arrayet
    $Info=getCharacterInfo($conn,$i,$Info);      
}
?>
<!-- h1 sluttes-->
</h1>
<!-- Der bliver lavet en knap til at se members-->
<a href="viewMembers.php"><button>Back</button></a>
<br><br>
<?php
//laver en varianble som sætter den lig falsk
$boolean = false;
//kører et forloop udfra mængden af CharacterIDer
for($i=1; $i<sizeof($Info)+1; $i++) {
    //Character idet bliver spruget over hvis den allerede har en contract med partyIDet
    if($Info[$i][1] <= 0){
        //hvis der er mindst en character som har en contract bliver booleanen sat sandt
        $boolean = true;
        ?>
        <!--Laver en tabel i html som skriver den fundede information-->
        <table style="background-color:#a08f70;width:40%;table-layout:fixed" border="3">
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
            <!--der bliver lavet en knap til contract siden, som submiter characterIDet og mængden der skal tilføjes hvilket alttid 1-->
            <form action="contract.php" method="post">
                <input type="Hidden" name="CharID" value="<?php echo $Info[$i][0] ?>">
                <button type="submit" name="Amount" value="1">Add Character</button>
            </form>
            <!--der bliver lavet en knap til editcharacter siden, som submiter characterIDet-->
            <form action="editCharacter.php" method="post">
                <button type="submit" name="CharacterID" value="<?php echo $Info[$i][0] ?>">Edit Character</button>
            </form>
            <!--der bliver lavet en knap til delete siden, som submiter characterIDet, samt at det er en Character-->
            <form action="deleteGroup.php" method="post">
                <input type="Hidden" name="Var" value="Character">
                <button type="submit" name="ID" value="<?php echo $Info[$i][0]; ?>">Delete Character</button>
	</form>
	<br>
	<br>
        <?php
    }
}
//Hvis booleanen ikke blev sat sandt, bliver skrevet der ikke var nogle charactere
if ($boolean==false){echo "There are no Characters<br>";}
//der bliver lavet knaper til at lave en nye charactere, og til at gå tilbage til at se membersne
?>
<a href="editCharacter.php"><button>Create New Character</button></a>
<a href="viewMembers.php"><button>Back</button></a>
</html>
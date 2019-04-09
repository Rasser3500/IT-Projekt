<html>
<?php
include"database.php";
$conn = getConnection();
$PartyID=isset($_POST['PartyID'])?$_POST['PartyID']:$_SESSION['PartyID'];
$_SESSION['PartyID']=$PartyID;
$PartyName=getName($conn,$PartyID,"Party");
echo "Members of ".$PartyName."<br><br>";
$Info=getID($conn,"Character");
for($i=1; $i<sizeof($Info)+1; $i++){
    $Info[$i][1]=getAmount($conn,$Info[$i][0],$PartyID,"Party");
    $Info=getCharacterInfo($conn,$i,$Info);    
}
$boolean = false;
for($i=1; $i<sizeof($Info)+1; $i++) {
    if($Info[$i][1] > 0){
        $boolean = true;
        ?>
        <table style="background-color:#875f43;width:40%;table-layout:fixed" border="3">
            <tr>
                <th>Name</th>
                <th>EXP</th>
                <th>Lvl</th>
                <th>Class</th>
                <th>Race</th>
            </tr>
            <tr>
                <td><?php echo $Info[$i][2];?></td>
                <td><?php echo $Info[$i][3];?></td>
                <td><?php echo $Info[$i][4];?></td>
                <td><?php echo $Info[$i][5];?></td>
                <td><?php echo $Info[$i][6];?></td>
            </tr>
        </table>
        <table>
            <td><form action="contract.php" method="post">
                <input type="Hidden" name="CharID" value="<?php echo $Info[$i][0] ?>">
                <input type="hidden" name="Home" value="True">
                <button type="submit" name="Amount" value="1">Remove from Party</button>
            </form></td>
            <td><form action="editCharacter.php" method="post">
                <button type="submit" name="CharacterID" value="<?php echo $Info[$i][0] ?>">Edit Character</button>
            </form></td>
        </table>
        <?php
    }
}
if ($boolean==false){echo "There are no Characters";}
?>
<a href="viewCharacters.php"><button>Contract Characters</button></a>
<br><br>
<a href="viewPartys.php"><button>Back</button></a>
</html>
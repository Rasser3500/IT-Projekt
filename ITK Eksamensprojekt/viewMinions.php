<html>
<?php
include"database.php";
$conn = getConnection();
$EncounterID=isset($_POST['EncounterID'])?$_POST['EncounterID']:$_SESSION['EncounterID'];
$_SESSION['EncounterID']=$EncounterID;
$EncounterName=getName($conn,$EncounterID,"Encounter");
echo "Minions of ".$EncounterName."<br>";
$AmountTotal=0;
$ExpTotal=0;
$Info=getID($conn,"Monster");
for($i=1; $i<sizeof($Info)+1; $i++){
    $Info[$i][1]=getAmount($conn,$Info[$i][0],$EncounterID,"Encounter");
    $Info=getMonsterInfo($conn,$Info[$i][0],$Info);
    $AmountTotal+=$Info[$i][1];
    $ExpTotal+=$Info[$i][7]*$Info[$i][1];
}
echo "Total exp of encounter: ".$ExpTotal*getMulti($AmountTotal)." <br><br>";
$boolean = false;
for($i=1; $i<sizeof($Info)+1; $i++) {
    if($Info[$i][1] > 0){
        $boolean = true;
        ?>
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
        <table>
            <td><form action="contract.php" method="post">
                <input type="text" name="Amount">
                <input type="hidden" name="Home" value="True">
                <button type="submit" name="CharID" value="<?php echo $Info[$i][0] ?>">Remove Monster</button>
            </form></td>
            <td><form action="editMonster.php" method="post">
                <button type="submit" name="MonsterID" value="<?php echo $Info[$i][0] ?>">Edit Monster</button>
            </form></td>
        </table>
        <?php
    }
}
if ($boolean==false){echo "There are no Monsters";}
?>
<a href="viewMonsters.php"><button>Contract Monsters</button></a>
<br><br>
<a href="viewEncounters.php"><button>Back</button></a>
</html>
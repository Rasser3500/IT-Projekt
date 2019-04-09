<html>
<?php
include"database.php";
$conn = getConnection();
$EncounterID=$_SESSION['EncounterID'];
$EncounterName=getName($conn,$EncounterID,"Encounter");
echo "Contract Monsters to ".$EncounterName."<br><br>";
$Info=getID($conn,"Monster");
for($i=1; $i<sizeof($Info)+1; $i++){
        $Info[$i][1]=getAmount($conn,$Info[$i][0],$EncounterID,"Encounter");
        $Info=getMonsterInfo($conn,$i,$Info);    
}
$boolean = false;
for($i=1; $i<sizeof($Info)+1; $i++) {
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
    <table>
        <td><form action="contract.php" method="post">
            <input type="Text" name="Amount">
            <button type="submit" name="CharID" value="<?php echo $Info[$i][0] ?>">Add Monster</button>
        </form></td>
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
if ($boolean==false){echo "There are no Monsters";}
?>
<a href="editMonster.php"><button>Create New Monster</button></a>
<br><br>
<a href="viewMinions.php"><button>Back</button></a>
</html>
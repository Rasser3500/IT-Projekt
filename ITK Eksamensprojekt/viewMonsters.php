<html>
<?php
include"database.php";
$conn = getConnection();
$EncounterID=$_SESSION['EncounterID'];
$EncounterName=getName($conn,$EncounterID,"Encounter");
echo "Contract Monsters to ".$EncounterName."<br><br>";
$Info = getALLCharInfo($conn,$EncounterID,"Encounter");
for($i=1; $i<sizeof($Info)+1; $i++) {
    ?>
    <table style="background-color:#875f43;width:40%;table-layout:fixed" border="3">
        <tr>
            <th>Name</th>
            <th>Size</th>
            <th>Cr</th>
            <th>Alignment</th>
            <th>Type</th>
            <th>Amount</th>
        </tr>
        <tr>
            <td><?php echo $Info[$i][1];?></td>
            <td><?php echo $Info[$i][2];?></td>
            <td><?php echo $Info[$i][3];?></td>
            <td><?php echo $Info[$i][4];?></td>
            <td><?php echo $Info[$i][5];?></td>
            <td><?php echo $Info[$i][0];?></td>
        </tr>
    </table>
    <table>
        <td><form action="contract.php" method="post">
            <input type="text" name="Amount" >
            <button type="submit" name="CharID" value="<?php echo $i ?>">Add Monster</button>
            </form></td>
        <td><form action="editMonster.php" method="post">
            <button type="submit" name="MonsterID" value="<?php echo $i ?>">Edit Monster</button>
            </form></td>
	</table>
	<br>
    <?php
}
?>
<br>
<a href="editMonster.php"><button>Create New Monster</button></a>
<br><br>
<a href="viewMinions.php"><button>Back</button></a>
</html>
<html>
<?php
include"database.php";
$conn = getConnection();
$PartyID=$_SESSION['PartyID'];
$PartyName=getName($conn,$PartyID,"Party");
echo "Contract Characters to ".$PartyName."<br><br>";
$Info = getALLCharInfo($conn,$PartyID,"Party");
$boolean = false;
for($i=1; $i<sizeof($Info)+1; $i++) {
    if($Info[$i][0] <= 0){
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
                <td><?php echo $Info[$i][1];?></td>
                <td><?php echo $Info[$i][2];?></td>
                <td><?php echo $Info[$i][3];?></td>
                <td><?php echo $Info[$i][4];?></td>
                <td><?php echo $Info[$i][5];?></td>
            </tr>
        </table>
        <table>
            <td><form action="contract.php" method="post">
                <input type="Hidden" name="CharID" value="<?php echo $i ?>">
                <button type="submit" name="Amount" value="1">Add Character</button>
                </form></td>
            <td><form action="editCharacter.php" method="post">
                <button type="submit" name="CharacterID" value="<?php echo $i ?>">Edit Character</button>
                </form></td>
	    </table>
	    <br>
        <?php
    }
}
if ($boolean==false){echo "There are no Characters";}
?>
<br>
<a href="editCharacter.php"><button>Create New Character</button></a>
<br><br>
<a href="viewMembers.php"><button>Back</button></a>
</html>
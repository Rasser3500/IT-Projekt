<html>
<?php
include"database.php";
$conn = getConnection();
$PartyID=$_SESSION['PartyID'];
$_SESSION['PartyID']=$PartyID;
$PartyName=getName($conn,$PartyID,"Party");
echo "Contract Characters to ".$PartyName."<br><br>";
$Info = getALLCharacterInfo($conn,$PartyID);
$boolean = false;
for($i=1; $i<sizeof($Info)+1; $i++) {
    if($Info[$i][0] == 0){
        $boolean = true;
<<<<<<< HEAD
        while($row = $result->fetch_assoc()) {
            $playID[$i][1]=$row["CharacterName"];
			$playID[$i][2]=$row["Class"];
            $playID[$i][3]=$row["Lvl"];
			$playID[$i][4]=$row["EXP"];
            $playID[$i][5]=$row["Race"];
        }
    }
}
for($i=1; $i<sizeof($playID)+1; $i++) {
    if($playID[$i][0] == 0){
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
			<td><?php echo $playID[$i][1];?></td>
			<td><?php echo $playID[$i][2];?></td>
			<td><?php echo $playID[$i][3];?></td>
			<td><?php echo $playID[$i][4];?></td>
			<td><?php echo $playID[$i][5];?></td>
		</tr>
		</table>
	<table>
        <td>	<form action="contract.php">
            <input type="Hidden" name="PartyID" value="<?php echo $PartyID ?>">
            <input type="Hidden" name="CharacterID" value="<?php echo $i ?>">
				<button type="submit" name="Member" value="1">Add Character</button>
				</form>
		</td>
        <td><form action="editCharacter.php">
            <input type="Hidden" name="PartyID" value="<?php echo $PartyID ?>">
=======
        echo $Info[$i][1]."<br>";
        echo " Lvl:".$Info[$i][3]. " ";
        echo $Info[$i][5]. " ";
        echo $Info[$i][4]. "<br>";
        echo " EXP:" .$Info[$i][2]. "<br>";
        ?>
        <form action="contract.php" method="post">
            <input type="Hidden" name="CharacterID" value="<?php echo $i ?>">
            <button type="submit" name="Member" value="1">Add Character</button>
        </form>
        <form action="editCharacter.php" method="post">
>>>>>>> IT-Projekt/master
            <button type="submit" name="CharacterID" value="<?php echo $i ?>">Edit Character</button>
        </form>
		</td>
	</table>
	<br>
       <?php
    }
}
		if ($boolean==false){echo "There are no Characters";}
?>
<br>
<<<<<<< HEAD
<form action="newCharacter.php">
    <button type="submit" name="PartyID" value="<?php echo $PartyID; ?>">Create New Character</button>
</form>
<form action="viewMembers.php">
   <button type="submit" name="PartyID" value="<?php echo $PartyID; ?>">Back</button>
</form>
		</html>
=======
<a href="editCharacter.php"><button>Create New Character</button></a>
<br><br>
<a href="viewMembers.php"><button>Back</button></a>
</html>
>>>>>>> IT-Projekt/master

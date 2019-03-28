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
            <button type="submit" name="CharacterID" value="<?php echo $i ?>">Edit Character</button>
        </form>
        <?php
    }
}
if ($boolean==false){echo "There are no Characters";}
?>
<br>
<form action="newCharacter.php">
    <button type="submit" name="PartyID" value="<?php echo $PartyID; ?>">Create New Character</button>
</form>
<form action="viewMembers.php">
   <button type="submit" name="PartyID" value="<?php echo $PartyID; ?>">Back</button>
</form>
</html>
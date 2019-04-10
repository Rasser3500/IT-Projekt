<html>
<?php
include"database.php";
$conn = getConnection();
$_SESSION['PartyID']=0;
echo "List of Parties<br><br>";
$GroupInfo=getID($conn,"Party");
for($i=1; $i<sizeof($GroupInfo)+1; $i++){
    echo getName($conn,$GroupInfo[$i][0],"Party");
    echo "<br> Party lvls: ";
    $CharInfo=getID($conn,"Character");
    for($j=1; $j<sizeof($CharInfo)+1; $j++){
        $CharInfo[$j][1]=getAmount($conn,$CharInfo[$j][0],$GroupInfo[$i][0],"Party");
        $CharInfo=getCharacterInfo($conn,$j,$CharInfo);
        if($CharInfo[$j][1] > 0){echo $CharInfo[$j][3]." ";}
    }
    ?>
    <form action="viewMembers.php" method="post">     
        <button type="submit" name="PartyID" value="<?php echo $GroupInfo[$i][0]; ?>">View Members</button>
    </form>
    <form action="viewEncounters.php" method="post">     
        <button type="submit" name="PartyID" value="<?php echo $GroupInfo[$i][0]; ?>">Pick Encounter</button>
    </form>
    <form action="deleteGroup.php" method="post">
        <input type="Hidden" name="Var" value="Party">
        <button type="submit" name="ID" value="<?php echo $GroupInfo[$i][0]; ?>">Delete Party</button>
    </form>
    <?php
}
?>
<br>
<form action="newGroup.php" method="post">     
    <button type="submit" name="Var" value="Party">Create Party</button>
</form>
<a href="homePage.php"><button>Back</button></a>
</html>
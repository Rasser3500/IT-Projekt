<html>
<?php
include"database.php";
$conn = getConnection();
$_SESSION['PartyID']=0;
echo "List of Parties<br><br>";
$Info=getID($conn,"Party");
for($i=1; $i<sizeof($Info)+1; $i++){
    echo getName($conn,$Info[$i][0],"Party");
    ?>
    <form action="viewMembers.php" method="post">     
        <button type="submit" name="PartyID" value="<?php echo $Info[$i][0]; ?>">View Members</button>
    </form>
    <form action="deleteGroup.php" method="post">
        <input type="Hidden" name="Var" value="Party">
        <button type="submit" name="ID" value="<?php echo $Info[$i][0]; ?>">Delete Party</button>
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
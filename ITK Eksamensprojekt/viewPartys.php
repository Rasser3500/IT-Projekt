<html>
<?php
include"database.php";
$conn = getConnection();
$_SESSION['PartyID']=0;
echo "List of Parties<br><br>";
$sql = "SELECT PartyID, Name FROM AdventureDB.PartyTable";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo $row["Name"]."<br>";
        ?>
        <form action="viewMembers.php" method="post">     
            <button type="submit" name="PartyID" value="<?php echo $row["PartyID"]; ?>">View Members</button>
        </form>
        <form action="deleteGroup.php" method="post">
            <input type="Hidden" name="Var" value="Party">
            <button type="submit" name="ID" value="<?php echo $row["PartyID"]; ?>">Delete Party</button>
        </form>
        <?php
    }
} else {
    echo "There are no Parties" . "<br>";
}
?>
<br>
<form action="newGroup.php" method="post">     
    <button type="submit" name="Var" value="Party">Create Party</button>
</form>
<br><a href="homePage.php"><button>Back</button></a>
</html>
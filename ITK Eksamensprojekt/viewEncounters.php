<html>
<?php
include"database.php";
$conn = getConnection();
$_SESSION['EncounterID']=0;
echo "List of Encounters<br><br>";
$sql = "SELECT EncounterID, Name FROM AdventureDB.EncounterTable";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo $row["Name"]."<br>";
        ?>
        <form action="viewMinions.php" method="post">     
            <button type="submit" name="EncounterID" value="<?php echo $row["EncounterID"]; ?>">View Minions</button>
        </form>
        <form action="deleteGroup.php" method="post">
            <input type="Hidden" name="Var" value="Encounter">
            <button type="submit" name="ID" value="<?php echo $row["EncounterID"]; ?>">Delete Encounter</button>
        </form>
        <?php
    }
} else {
    echo "There are no Encounters" . "<br>";
}
?>
<br>
<form action="newGroup.php" method="post">     
    <button type="submit" name="Var" value="Encounter">Create Encounter</button>
</form>
<a href="homePage.php"><button>Back</button></a>
</html>

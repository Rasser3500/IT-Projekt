<html>
<?php
include"Connect.php";
$sql = "SELECT EncounterID, Name FROM EncounterDB.EncounterTable";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo " Encounter:  " . $row["Encounter"]."<br>";
        ?>
        <form action="viewMonsters.php">
            <button type="submit" name="EncounterID" value="<?php echo $row["EncounterID"]; ?>">View Monsters</button>
        </form>
        <form action="deleteEncounter.php"><button type="submit" name="EncounterID" value="<?php echo $row["EncounterID"]; ?>">Delete Encounter</button> </form><?php
    }
} else {
    echo "There are no Encounters" . "<br>";
}
?>
<a href="newEncounter.php"><button>New Encounter</button></a>
</html>

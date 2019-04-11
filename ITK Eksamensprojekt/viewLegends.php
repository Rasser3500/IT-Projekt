<html>
<?php
include"database.php";
error_reporting(E_ERROR | E_PARSE);
$conn = getConnection();
$LegendInfo=getID($conn,"Legend");
for($i=1; $i<sizeof($LegendInfo)+1; $i++){
    $ID=$LegendInfo[$i][0];
    $sql = "SELECT PartyID, EncounterID FROM AdventureDB.LegendTable WHERE LegendID='$ID'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $LegendInfo[$i][1]=$row["PartyID"];
            $LegendInfo[$i][2]=$row["EncounterID"];
            
        }
    }
    echo getName($conn,$LegendInfo[$i][2],"Encounter")." was fought by ".getName($conn,$LegendInfo[$i][1],"Party");
    ?>
    <form action="deleteGroup.php" method="post">
        <input type="Hidden" name="Var" value="Legend">
        <button type="submit" name="ID" value="<?php echo $LegendInfo[$i][0]; ?>">Undo fight</button>
    </form><br>
    <?php
}
?>
<a href="homePage.php"><button>Back</button></a>
</html>
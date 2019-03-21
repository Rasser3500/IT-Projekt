<html>
<?php
include"Connect.php";
$sql = "SELECT PartyID, PartyName FROM AdventureDB.PartyTable";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo " Party:  " . $row["PartyName"]."<br>";
        ?>
        <form action="viewPlayers.php">
            <button type="submit" name="PartyID" value="<?php echo $row["PartyID"]; ?>">View Players</button>
        </form>
        <form action="deleteParty.php"><button type="submit" name="PartyID" value="<?php echo $row["PartyID"]; ?>">Delete Party</button> </form><?php
    }
} else {
    echo "There are no Parties" . "<br>";
}
?>
<br><a href="newParty.php"><button>New Party</button></a><br>
<br><a href="homePage.php"><button>Back</button></a>
</html>
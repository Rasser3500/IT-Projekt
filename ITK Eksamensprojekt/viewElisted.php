<html>
<?php
include"Connect.php";
$PartyID = $_GET["PartyID"];
$sql = "SELECT Name, Balance FROM AdventureDB.PartyTable WHERE PartyID='$PartyID'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo $row["PartyName"]."'s Party members";
    }
}
$sql = "SELECT COUNT(PlayerID) FROM AdventureDB.PlayerTable";
$result = $conn->query($sql);
$MaxID = $result->fetch_assoc();
$playID = [];
for($i=1; $i<$MaxID["COUNT(PlayerID)"]+1; $i++) {
    $y=0;
    $sql = "SELECT Enlisted FROM AdventureDB.ContractTable WHERE PartyID = '$PartyID' AND PlayerID = '$i'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        if($row["Enlisted"]=1){ $y=$y+1; }
        else{ $y=$y-1; }
    }
}
    $playID[$i][0]=$y;
}
for($i=1; $i<sizeof($playID)+1; $i++){
    $sql = "SELECT PlayerName, EXP, Lvl, Class, Race FROM AdventureDB.PlayerTable WHERE PlayerID = '$i'";
    $result = $conn->query($sql);
    if ($result->num_rows != 0) {
        while($row = $result->fetch_assoc()) {
            $playID[$i][1]=$row["Name"];
            $playID[$i][2]=$row["EXP"];
            $playID[$i][3]=$row["Lvl"];
            $playID[$i][4]=$row["Class"];
            $playID[$i][5]=$row["Race"];
        }
    }
}
for($i=1; $i<sizeof($playID)+1; $i++) {
    if($playID[$i][0] != 0){
        echo " Name:  ".$playID[$i][1]."<br>";
        echo " EXP:  " .$playID[$i][2]. "$<br>";
        echo " Lvl:  ".$playID[$i][3]."<br>";
        echo " Class:  " .$playID[$i][4]. "$<br>";
        echo " Race:  ".$playID[$i][5]."<br>";
        ?>
        <form action="removePlayer.php">
            <?php echo "Amount to sell"; ?>
            <input type="hidden" name="PartyID" value="<?php echo $PartyID; ?>">
            <button type="submit" name="PlayerID"  value="<?php echo $i; ?>">Sell Player</button>
        </form><?php
    }
}
?>
<form action="buySell.php">
    <button type="submit" name="PartyID" value="<?php echo $PartyID; ?>">Buy Players</button>
</form>
<form action="homePage.php">
    <button type="submit" name="PartyID" value="<?php echo $PartyID; ?>">Back</button>
</form>
</html>
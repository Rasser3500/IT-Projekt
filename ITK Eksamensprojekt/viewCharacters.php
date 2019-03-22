<html>
<?php
include"Connect.php";
$PartyID = $_GET["PartyID"];
$sql = "SELECT PartyName FROM AdventureDB.PartyTable WHERE PartyID='$PartyID'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo " Contract Characters to " . $row["PartyName"]."<br><br>";
    }
}

$sql = "SELECT COUNT(CharacterID) FROM AdventureDB.CharacterTable";
$result = $conn->query($sql);
$MaxID = $result->fetch_assoc();
$playID = [];
for($i=1; $i<$MaxID["COUNT(CharacterID)"]+1; $i++) {
    $y=0;
    $sql = "SELECT Member FROM AdventureDB.ContractTable WHERE PartyID = '$PartyID' AND CharacterID = '$i'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        if($row["Member"]==1){ $y=$y+1; }
        else{ $y=$y-1; }
    }
}
    $playID[$i][0]=$y;
}
$boolean = false;
for($i=1; $i<$MaxID["COUNT(CharacterID)"]+1; $i++){
    $sql = "SELECT CharacterName, EXP, Lvl, Class, Race FROM AdventureDB.CharacterTable WHERE CharacterID = '$i'";
    $result = $conn->query($sql);
    if ($result->num_rows != 0) {
        $boolean = true;
        while($row = $result->fetch_assoc()) {
            $playID[$i][1]=$row["CharacterName"];
            $playID[$i][2]=$row["EXP"];
            $playID[$i][3]=$row["Lvl"];
            $playID[$i][4]=$row["Class"];
            $playID[$i][5]=$row["Race"];
        }
    }
}
for($i=1; $i<sizeof($playID)+1; $i++) {
    if($playID[$i][0] == 0){
        echo $playID[$i][1]."<br>";
        echo " Lvl:".$playID[$i][3]. " ";
        echo $playID[$i][5]. " ";
        echo $playID[$i][4]. "<br>";
        echo " EXP:" .$playID[$i][2]. "<br>";
        ?>
        <form action="contract.php">
            <input type="Hidden" name="PartyID" value="<?php echo $PartyID ?>">
            <input type="Hidden" name="CharacterID" value="<?php echo $i ?>">
            <button type="submit" name="Member" value="1">Add Character</button>
        </form>
        <form action="editCharacter.php">
            <input type="Hidden" name="PartyID" value="<?php echo $PartyID ?>">
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
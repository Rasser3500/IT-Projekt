<html>
<?php
include"database.php";
$conn = getConnection();
$PartyID=isset($_POST['PartyID'])?$_POST['PartyID']:$_SESSION['PartyID'];
$EncounterID=isset($_POST['EncounterID'])?$_POST['EncounterID']:$_SESSION['EncounterID'];
$Group=$_POST['Group'];
$sql = "INSERT INTO AdventureDB.LegendTable (PartyID, EncounterID) Value('$PartyID', '$EncounterID')";
if ($conn->query($sql) === TRUE) {echo getName($conn,$PartyID,"Party")." has fought ".getName($conn,$EncounterID,"Encounter")."<br>";}
else {echo "Error: " . $sql . "<br>" . $conn->error;}
$MonsAmountTotal=0;
$ExpTotal=0;
$MonsInfo=getID($conn,"Monster");
for($i=1; $i<sizeof($MonsInfo)+1; $i++){
    $MonsInfo[$i][1]=getAmount($conn,$MonsInfo[$i][0],$EncounterID,"Encounter");
    $MonsInfo=getMonsterInfo($conn,$MonsInfo[$i][0],$MonsInfo);
    $MonsAmountTotal+=$MonsInfo[$i][1];
    $ExpTotal+=$MonsInfo[$i][7]*$MonsInfo[$i][1];
}    
$CharAmountTotal=0;
$CharInfo=getID($conn,"Character");
for($i=1; $i<sizeof($CharInfo)+1; $i++){
    $CharInfo[$i][1]=getAmount($conn,$CharInfo[$i][0],$PartyID,"Party");
    $CharInfo=getCharacterInfo($conn,$i,$CharInfo);
    if($CharInfo[$i][1]>0){$CharAmountTotal+=1;}
}
$AvgExp=($ExpTotal*getMulti($MonsAmountTotal))/$CharAmountTotal;
for($i=1; $i<sizeof($CharInfo)+1; $i++){
    if($CharInfo[$i][1]>0){
        $NewExp=$AvgExp+$CharInfo[$i][4];
        $CharacterID=$CharInfo[$i][0];
        $sql = "UPDATE AdventureDB.CharacterTable SET EXP = '$NewExp' WHERE CharacterID = '$CharacterID'";
        if ($conn->query($sql) === TRUE) {}
        else {echo "Error: " . $sql . "<br>" . $conn->error;}
    }
}
echo "and have each gained ".$AvgExp." Exp";
?>
<br><br>
<a href="<?php echo "view".$Group."s.php" ?>"><button>Ok</button></a>
</html>
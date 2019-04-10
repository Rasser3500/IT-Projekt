<html>
<?php
include"database.php";
$conn = getConnection();
$_SESSION['EncounterID']=0;
$PartyID=isset($_POST['PartyID'])?$_POST['PartyID']:$_SESSION['PartyID'];
echo "List of Encounters<br><br>";
$GroupInfo=getID($conn,"Encounter");
for($i=1; $i<sizeof($GroupInfo)+1; $i++){
    echo getName($conn,$GroupInfo[$i][0],"Encounter")."<br>";
    $AmountTotal=0;
    $ExpTotal=0;
    $CharInfo=getID($conn,"Monster");
    for($j=1; $j<sizeof($CharInfo)+1; $j++){
        $CharInfo[$j][1]=getAmount($conn,$CharInfo[$j][0],$GroupInfo[$i][0],"Encounter");
        $CharInfo=getMonsterInfo($conn,$CharInfo[$j][0],$CharInfo);
        $AmountTotal+=$CharInfo[$j][1];
        $ExpTotal+=$CharInfo[$j][7]*$CharInfo[$j][1];
    }
    echo "Total exp: ".$ExpTotal*getMulti($AmountTotal)." <br><br>";
    ?>
    <form action="viewMinions.php" method="post">     
        <button type="submit" name="EncounterID" value="<?php echo $GroupInfo[$i][0]; ?>">View Minions</button>
    </form>
    <form action="deleteGroup.php" method="post">
        <input type="Hidden" name="Var" value="Encounter">
        <button type="submit" name="ID" value="<?php echo $GroupInfo[$i][0]; ?>">Delete Encounter</button>
    </form>
    <?php
}
?>
<br>
<form action="newGroup.php" method="post">     
    <button type="submit" name="Var" value="Encounter">Create Encounter</button>
</form>
<a href="homePage.php"><button>Back</button></a>
</html>

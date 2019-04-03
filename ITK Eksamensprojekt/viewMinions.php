<html>
<?php
include"database.php";
$conn = getConnection();
$EncounterID=isset($_POST['EncounterID'])?$_POST['EncounterID']:$_SESSION['EncounterID'];
$_SESSION['EncounterID']=$EncounterID;
$EncounterName=getName($conn,$EncounterID,"Encounter");
echo "Minions of ".$EncounterName."<br><br>";
$Info = getALLCharInfo($conn,$EncounterID,"Encounter");
$boolean = false;
for($i=1; $i<sizeof($Info)+1; $i++) {
    if($Info[$i][0] > 0){
        $boolean = true;
        echo $Info[$i][0]." ";
        echo $Info[$i][1]." ";
        echo " Cr: ".$Info[$i][3]. " ";
        ?>
        <form action="contract.php" method="post">
            <input type="Text" name="Amount">
            <input type="hidden" name="Home" value="True">
            <button type="submit" name="CharID" value="<?php echo $i ?>">Remove from Encounter</button>
        </form>
        <form action="editMonster.php" method="post">
            <button type="submit" name="MonsterID" value="<?php echo $i ?>">Edit Monster</button>
        </form>
        <?php
    }
}
if ($boolean==false){echo "There are no minions";}
?>
<br>
<a href="viewMonsters.php"><button>Contract Monsters</button></a>
<br><br>
<a href="viewEncounters.php"><button>Back</button></a>
</html>
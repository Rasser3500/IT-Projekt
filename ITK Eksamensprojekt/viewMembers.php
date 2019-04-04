<html>
<?php
include"database.php";
$conn = getConnection();
$PartyID=isset($_POST['PartyID'])?$_POST['PartyID']:$_SESSION['PartyID'];
$_SESSION['PartyID']=$PartyID;
$PartyName=getName($conn,$PartyID,"Party");
echo "Members of ".$PartyName."<br><br>";
$Info = getALLCharInfo($conn,$PartyID,"Party");
$boolean = false;
for($i=1; $i<sizeof($Info)+1; $i++) {
    if($Info[$i][0] > 0){
        $boolean = true;
        echo $Info[$i][1]."<br>";
        echo " Lvl:".$Info[$i][3]. " ";
        echo $Info[$i][5]. " ";
        echo $Info[$i][4]. "<br>";
        echo " EXP:" .$Info[$i][2]. "<br>";
        ?>
        <form action="contract.php" method="post">
            <input type="Hidden" name="CharID" value="<?php echo $i ?>">
            <input type="hidden" name="Home" value="True">
            <button type="submit" name="Amount" value="1">Remove from Party</button>
        </form>
        <form action="editCharacter.php" method="post">
            <button type="submit" name="CharacterID" value="<?php echo $i ?>">Edit Character</button>
        </form>
        <?php
    }
}
if ($boolean==false){echo "There are no members";}
?>
<br>
<a href="viewCharacters.php"><button>Contract Characters</button></a>
<br><br>
<a href="viewPartys.php"><button>Back</button></a>
</html>
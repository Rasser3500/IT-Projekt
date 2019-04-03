<html>
<?php
include"database.php";
$conn = getConnection();
if ($_SESSION['PartyID']!=0){$Group="Party"; $Char="Character";}
if ($_SESSION['EncounterID']!=0){$Group="Encounter"; $Char="Monster";}
$Home=isset($_POST['Home'])?$_POST['Home']:"False";
echo $Home;
$GroupID=$_SESSION[$Group.'ID'];
$CharID = $_POST["CharID"];
$Amount = $_POST["Amount"];
if ($Home=="True"){$Amount*=-1;}
$GroupName=getName($conn,$GroupID,$Group);
$CharName=getName($conn,$CharID,$Char);
if ($Amount>0){$string="joined";}
else {$string="left";}   
$sql = "INSERT INTO AdventureDB.ContractTable (GroupID, CharID, Amount, Type) Value('$GroupID', '$CharID', '$Amount', '$Group')";
if ($conn->query($sql) === TRUE) { echo $_POST["Amount"]." ".$CharName." has ".$string." ".$GroupName;}
else {echo "Error: " . $sql . "<br>" . $conn->error;}
if ($Home=="True" && $Char=="Character"){$Char="Member";}
if ($Home=="True" && $Char=="Monster"){$Char="Minion";}
?>
<br><br>
<a href="<?php echo "view".$Char."s.php" ?>"><button>Ok</button></a>
</html>
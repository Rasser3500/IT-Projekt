<html>
<?php
include"database.php";
$conn = getConnection();
$Amount = $_POST["Amount"];
if ($_SESSION['PartyID']!=0){$Group="Party"; $Char="Character";}
if ($_SESSION['EncounterID']!=0){$Group="Encounter"; $Char="Monster"; echo $Amount." ";}
$Home=isset($_POST['Home'])?$_POST['Home']:"False";
$GroupID=$_SESSION[$Group.'ID'];
$CharID = $_POST["CharID"];
if ($Home=="True"){$Amount*=-1;}
$GroupName=getName($conn,$GroupID,$Group);
$CharName=getName($conn,$CharID,$Char);
if ($Amount>0){$string="joined";}
else {$string="left";}   
$sql = "INSERT INTO AdventureDB.ContractTable (GroupID, CharID, Amount, Type) Value('$GroupID', '$CharID', '$Amount', '$Group')";
if ($conn->query($sql) === TRUE) { echo $CharName." has ".$string." ".$GroupName;}
else {echo "Error: " . $sql . "<br>" . $conn->error;}
if ($Home=="True" && $Char=="Character"){$Char="Member";}
if ($Home=="True" && $Char=="Monster"){$Char="Minion";}
?>
<br><br>
<a href="<?php echo "view".$Char."s.php" ?>"><button>Ok</button></a>
</html>
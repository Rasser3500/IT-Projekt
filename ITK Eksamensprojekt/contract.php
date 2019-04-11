<html>
<!-- der bliver refreret til stylesheetet-->
<link rel="stylesheet" type="text/css" href="stylesheet.css" />
<?php
//inkludere databasens funktioner og for connection
include"database.php";
$conn = getConnection();
//laver en int hvis værdig er lig med den givende Amount
$Amount = $_POST["Amount"];
//kigger på Session iderne for at finde ud af hvor informationen er sent fra og sætter stringsne til at være passende
if ($_SESSION['PartyID']!=0){$Group="Party"; $Char="Character";}
//hvis der er en encounterID bliver Amount også skrevet
if ($_SESSION['EncounterID']!=0){$Group="Encounter"; $Char="Monster"; echo $Amount." ";}
//Home bliver sat lig True eller False alt ud fra den givende home
$Home=isset($_POST['Home'])?$_POST['Home']:"False";
//GroupIDen bliver sat til den givende gruppesID gennem session
$GroupID=$_SESSION[$Group.'ID'];
//CharIDen bliver sat til den CharIDen fra POST
$CharID = $_POST["CharID"];
//hvis Home er true bliver Amount sat negativ
if ($Home=="True"){$Amount*=-1;}
//Navnet på Char og dens gruppes navn bliver fundet.
$GroupName=getName($conn,$GroupID,$Group);
$CharName=getName($conn,$CharID,$Char);
//hvis amount er flertal, bliver der sat et flertals s på CharName
if ($Amount>1 || $Amount<-1){$CharName.="s";}
//hvis amount er større end 0 bliver for en string værdien joind, eller bliver den lig left
if ($Amount>0){$string="joined";}
else {$string="left";}
// de groupId, CharID, Amount og grouptypen blive sat ind i Contracttablen i databasen
$sql = "INSERT INTO AdventureDB.ContractTable (GroupID, CharID, Amount, Type) Value('$GroupID', '$CharID', '$Amount', '$Group')";
//hvis insættelsen var succeful bliver charnavnet skrevet samt om den har joined eller left dens gruppes navn
if ($conn->query($sql) === TRUE) { echo $CharName." has ".$string." ".$GroupName;}
//hvis der skete en fejl bliver den istedet skrevet
else {echo "Error: " . $sql . "<br>" . $conn->error;}
//Char værdigen bliver defter ændret hvis home erlig true til den respektive værdig
if ($Home=="True" && $Char=="Character"){$Char="Member";}
if ($Home=="True" && $Char=="Monster"){$Char="Minion";}
?>
<!--knap bliver som sender til en side der er bestemt ud fra char værdien -->
<br><br>
<a href="<?php echo "view".$Char."s.php" ?>"><button>Ok</button></a>
</html>
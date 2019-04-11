<html>
<?php
//inkludere databasens funktioner og for connection
include"database.php";
$conn = getConnection();
//finder alle LegendIDerne og sætter dem i et array, hvor de kan findes som den 0'de information til et nummeret
$LegendInfo=getID($conn,"Legend");
//kører et forloop udfra hvormange LegendIDer der blev fundet. 
for($i=1; $i<sizeof($LegendInfo)+1; $i++){
    //finder Party og Encounter IDet til LegendIdet og sætter dem ind i arrayet
    $ID=$LegendInfo[$i][0];
    $sql = "SELECT PartyID, EncounterID FROM AdventureDB.LegendTable WHERE LegendID='$ID'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $LegendInfo[$i][1]=$row["PartyID"];
            $LegendInfo[$i][2]=$row["EncounterID"];
            
        }
    }
    //finder navnet i Party og Encounter IDet og skriver dem
    echo getName($conn,$LegendInfo[$i][2],"Encounter")." was fought by ".getName($conn,$LegendInfo[$i][1],"Party");
    ?>
    <!--laver en knap til at submit dette legendId med til delete group siden, samt en hidden var med stringen "Legend" -->
    <form action="deleteGroup.php" method="post">
        <input type="Hidden" name="Var" value="Legend">
        <button type="submit" name="ID" value="<?php echo $LegendInfo[$i][0]; ?>">Undo fight</button>
    </form><br>
    <?php
}
?>
<!--laver en knap til homepage-->
<a href="homePage.php"><button>Back</button></a>
</html>
<html>
<?php
include"database.php";
$conn=getConnection();
$Name = $_GET["Name"];
$EXP = $_GET["EXP"];
$Lvl = $_GET["Lvl"];
$Class = $_GET["Class"];
$Race = $_GET["Race"];

$sql = "INSERT INTO AdventureDB.CharacterTable (Name, EXP, Lvl, Class, Race) Value('$Name', '$EXP', '$Lvl', '$Class', '$Race')";

if ($conn->query($sql) === TRUE) {
    echo "New Character added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
<a href="viewCharacters.php"><button>Ok</button></a>
</html>
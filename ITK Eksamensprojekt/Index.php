<html>
<?php
include"Connect.php";
$sql = "CREATE DATABASE AdventureDB";
if ($conn->query($sql) === TRUE) {
    echo "Database created"."<br>";
} else {
    echo $conn->error."<br>";
}

$sql = "CREATE TABLE adventureDB.PlayerTable (
PlayerID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
PlayerName VARCHAR(60) NOT NULL,
Lvl INT(2) NOT NULL,
EXP int(10),
Class VARCHAR(20) NOT NULL,
Race VARCHAR(20) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "PlayerTable created "."<br>";
} else {
    echo $conn->error."<br>";
}
	
$sql = "CREATE TABLE adventureDB.ContractTable (
ContractID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
PlayerID INT(6),
PartyID INT(6),
Enlisted BIT(1)
)";

if ($conn->query($sql) === TRUE) {
    echo "ContractTable created "."<br>";
} else {
    echo $conn->error."<br>";
}
	
$sql = "CREATE TABLE adventureDB.PartyTable (
PartyID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
PartyName VARCHAR(60) NOT NULL
)";	
	
if ($conn->query($sql) === TRUE) {
    echo "PartyTable created "."<br>";
} else {
    echo $conn->error."<br>";
}

$sql = "CREATE TABLE adventureDB.EncounterTable (
EncounterID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
EncounterName VARCHAR(60) NOT NULL
)";	
	
if ($conn->query($sql) === TRUE) {
    echo "EncounterTable created "."<br>";
} else {
    echo $conn->error."<br>";
}	
	
$sql = "CREATE TABLE adventureDB.EventTable (
EventID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
EncounterID INT(6) NOT NULL,
MonsterID INT(6) NOT NULL,
Amount INT(6) NOT NULL
)";	
	
if ($conn->query($sql) === TRUE) {
    echo "EventTable created "."<br>";
} else {
    echo $conn->error."<br>";
}	

$sql = "CREATE TABLE adventureDB.MonsterTable (
MonsterID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
MonsterName VARCHAR(60) NOT NULL,
Size VARCHAR(20) NOT NULL,
CR FLOAT(10) NOT NULL,
Alignment VARCHAR(20) NOT NULL,
Type VARCHAR(20) NOT NULL
)";	
	
if ($conn->query($sql) === TRUE) {
    echo "PartyTable created "."<br>";
} else {
    echo $conn->error."<br>";
}
	
    $conn->close();
?>
<a href="homePage.php"><button>Ok</button></a>
</html>

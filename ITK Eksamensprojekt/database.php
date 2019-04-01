<?php
session_start();
$GLOBALS['debug'] = false;
if($GLOBALS['debug']){ 
    echo "<br>DEBUG: database.php included";
}
function createAll($conn){
    createDatabase($conn);
    createCharacterTable($conn);
    createContractTable($conn);
    createPartyTable($conn);
    createEncounterTable($conn);
    createMonsterTable($conn);
}
function getConnection(){
    $conn = new mysqli("localhost", "root", "root");
    return $conn;
}
function createDatabase($conn){
    $sql = "CREATE DATABASE AdventureDB";
    $dbCreated = $conn->query($sql);
    if($GLOBALS['debug']){
        if ($dbCreated) {
            echo "<br>DEBUG:Database created successfully";
        } else {
            echo "<br>DEBUG:Error creating database: " . $conn->error;
        }
    }    
}
function createCharacterTable($conn){
    $sql = "CREATE TABLE AdventureDB.CharacterTable (
    CharacterID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(60) NOT NULL,
    Lvl INT(2) NOT NULL,
    EXP int(10),
    Class VARCHAR(20) NOT NULL,
    Race VARCHAR(20) NOT NULL
    )";
    $chtCreated = $conn->query($sql);
    if($GLOBALS['debug']){
        if ($chtCreated) {
            echo "<br>DEBUG:CharacterTable created successfully";
        } else {
            echo "<br>DEBUG:Error creating CharacterTable: " . $conn->error;
        }
    }  
}
function createContractTable($conn){
    $sql = "CREATE TABLE AdventureDB.ContractTable (
    ContractID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    CharacterID INT(6),
    PartyID INT(6),
    Member INT(1)
    )";
    $cotCreated = $conn->query($sql);
    if($GLOBALS['debug']){
        if ($cotCreated) {
            echo "<br>DEBUG:ContractTable created successfully";
        } else {
            echo "<br>DEBUG:Error creating ContractTable: " . $conn->error;
        }
    }  
}
function createPartyTable($conn){
    $sql = "CREATE TABLE AdventureDB.PartyTable (
    PartyID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(60) NOT NULL
    )";	
    $ptCreated = $conn->query($sql);
    if($GLOBALS['debug']){
        if ($ptCreated) {
            echo "<br>DEBUG:PartyTable created successfully";
        } else {
            echo "<br>DEBUG:Error creating PartyTable: " . $conn->error;
        }
    }  
}
function createEncounterTable($conn){
    $sql = "CREATE TABLE adventureDB.EncounterTable (
    EncounterID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(60) NOT NULL
    )";	
    $etCreated = $conn->query($sql);
    if($GLOBALS['debug']){
        if ($etCreated) {
            echo "<br>DEBUG:EncounterTable created successfully";
        } else {
            echo "<br>DEBUG:Error creating EncounterTable: " . $conn->error;
        }
    }  
}
function createMonsterTable($conn){
    $sql = "CREATE TABLE adventureDB.MonsterTable (
    MonsterID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(60) NOT NULL,
    Size VARCHAR(20) NOT NULL,
    CR FLOAT(10) NOT NULL,
    Alignment VARCHAR(20) NOT NULL,
    Type VARCHAR(20) NOT NULL
    )";	
    $mtCreated = $conn->query($sql);
    if($GLOBALS['debug']){
        if ($mtCreated) {
            echo "<br>DEBUG:MonsterTable created successfully";
        } else {
            echo "<br>DEBUG:Error creating MonsterTable: " . $conn->error;
        }
    }  
}   
function createGroup($conn,$Name,$Var){
    $sql = "INSERT INTO AdventureDB.".$Var."Table (Name) Value('$Name')";
    return $conn->query($sql);
    $conn->close();
}
function deleteGroup($conn,$ID,$Var){
    $sql = "DELETE FROM AdventureDB.".$Var."Table WHERE ".$Var."ID='$ID'";
    return $conn->query($sql);
    $conn->close();
}
function getName($conn,$ID,$Var){
    $sql = "SELECT Name FROM AdventureDB.".$Var."Table WHERE ".$Var."ID='$ID'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row["Name"];
        }
    }
}
function getMax($conn,$Object,$Table){
    $sql = "SELECT COUNT($Object) FROM AdventureDB.$Table";
    $result = $conn->query($sql);
    return $result->fetch_assoc(); 
}
function getALLCharacterInfo($conn,$PartyID){
    $CharTotal=getMax($conn,"CharacterID","CharacterTable")["COUNT(CharacterID)"];
    $CharInfo=[];
    $CharInfo=getCharacterMembership($conn,1,$CharTotal,$PartyID,$CharInfo);
    $CharInfo=getCharacterInfo($conn,1,$CharTotal,$CharInfo);
    return $CharInfo;
}
function getCharacterMembership($conn,$Start,$Max,$PartyID,$CharInfo){
    for($i=$Start; $i<$Max+1; $i++) {
        $y=0;
        $sql = "SELECT Member FROM AdventureDB.ContractTable WHERE PartyID = '$PartyID' AND CharacterID = '$i'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if($row["Member"]==1){ $y=$y+1; }
                else{ $y=$y-1; }
            }
        }
        $CharInfo[$i][0]=$y;
    }
    return $CharInfo;
}
function getCharacterInfo($conn,$Start,$Max,$CharInfo){
    for($i=$Start; $i<$Max+1; $i++){
        $sql = "SELECT Name, EXP, Lvl, Class, Race FROM AdventureDB.CharacterTable WHERE CharacterID = '$i'";
        $result = $conn->query($sql);
        if ($result->num_rows != 0) {
            while($row = $result->fetch_assoc()) {
                $CharInfo[$i][1]=$row["Name"];
                $CharInfo[$i][2]=$row["EXP"];
                $CharInfo[$i][3]=$row["Lvl"];
                $CharInfo[$i][4]=$row["Class"];
                $CharInfo[$i][5]=$row["Race"];
            }
        }
    }
    return $CharInfo;
}
function updateCharacter($conn,$CharacterID,$Name,$EXP,$Lvl,$Class,$Race){
    $sql = "UPDATE AdventureDB.CharacterTable SET Name = '$Name', EXP = '$EXP', Lvl = '$Lvl', Class = '$Class', Race = '$Race' WHERE CharacterID='$CharacterID'";
    return $conn->query($sql);
    $conn->close();
}
function createCharacter($conn,$Name,$EXP,$Lvl,$Class,$Race){
    $sql = "INSERT INTO AdventureDB.CharacterTable (Name, EXP, Lvl, Class, Race) Value('$Name', '$EXP', '$Lvl', '$Class', '$Race')";
    return $conn->query($sql);
    $conn->close();
}
?>
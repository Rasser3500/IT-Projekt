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
    CharID INT(6) NOT NULL,
    GroupID INT(6) NOT NULL,
    Amount INT(6) NOT NULL,
    Type VARCHAR(20) NOT NULL
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
function createGroup($conn,$Name,$Group){
    $sql = "INSERT INTO AdventureDB.".$Group."Table (Name) Value('$Name')";
    return $conn->query($sql);
    $conn->close();
}
function deleteGroup($conn,$ID,$Group){
    $sql = "DELETE FROM AdventureDB.".$Group."Table WHERE ".$Group."ID='$ID'";
    return $conn->query($sql);
    $conn->close();
}
function getName($conn,$ID,$String){
    $sql = "SELECT Name FROM AdventureDB.".$String."Table WHERE ".$String."ID='$ID'";
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
    return $result->fetch_assoc()["COUNT($Object)"];
}
function getALLCharInfo($conn,$GroupID,$Group){
    $CharInfo=[];
    if ($Group=="Party"){$Char="Character";}
    if ($Group=="Encounter"){$Char="Monster";}
    $CharTotal=getMax($conn,$Char."ID",$Char."Table");
    for($i=1; $i<$CharTotal+1; $i++){
        $CharInfo[$i][0]=getAmount($conn,$i,$GroupID,$Group);
        $CharInfo=getCharInfo($conn,$i,$Char,$CharInfo);    
    }
    return $CharInfo;
}
function getAmount($conn,$ID,$GroupID,$Group){
    $sql = "SELECT SUM(Amount) FROM AdventureDB.ContractTable WHERE GroupID = '$GroupID' AND CharID = '$ID' AND Type = '$Group'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row["SUM(Amount)"];
        }
    }
}
function getCharInfo($conn,$ID,$Char,$CharInfo){
    if ($Char=="Character"){
        $sql = "SELECT Name, EXP, Lvl, Class, Race FROM AdventureDB.CharacterTable WHERE CharacterID = '$ID'";
        $result = $conn->query($sql);
        if ($result->num_rows != 0) {
            while($row = $result->fetch_assoc()) {
                $CharInfo[$ID][1]=$row["Name"];
                $CharInfo[$ID][2]=$row["EXP"];
                $CharInfo[$ID][3]=$row["Lvl"];
                $CharInfo[$ID][4]=$row["Class"];
                $CharInfo[$ID][5]=$row["Race"];
            }
        }
    }
    if ($Char=="Monster"){
        $sql = "SELECT Name, Size, Cr, Alignment, Type FROM AdventureDB.MonsterTable WHERE MonsterID = '$ID'";
        $result = $conn->query($sql);
        if ($result->num_rows != 0) {
            while($row = $result->fetch_assoc()) {
                $CharInfo[$ID][1]=$row["Name"];
                $CharInfo[$ID][2]=$row["Size"];
                $CharInfo[$ID][3]=$row["Cr"];
                $CharInfo[$ID][4]=$row["Alignment"];
                $CharInfo[$ID][5]=$row["Type"];
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
function updateMonster($conn,$MonsterID,$Name,$Size,$Cr,$Alignment,$Type){
    $sql = "UPDATE AdventureDB.MonsterTable SET Name = '$Name', Size = '$Size', Cr = '$Cr', Alignment = '$Alignment', Type = '$Type' WHERE MonsterID='$MonsterID'";
    return $conn->query($sql);
    $conn->close();
}
function createMonster($conn,$Name,$Size,$Cr,$Alignment,$Type){
    $sql = "INSERT INTO AdventureDB.MonsterTable (Name, Size, Cr, Alignment, Type) Value('$Name', '$Size', '$Cr', '$Alignment', '$Type')";
    return $conn->query($sql);
    $conn->close();
}
?>
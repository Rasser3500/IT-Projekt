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
function updateCharacter($conn,$CharacterID,$Name,$EXP,$Class,$Race){
    $sql = "UPDATE AdventureDB.CharacterTable SET Name = '$Name', EXP = '$EXP', Class = '$Class', Race = '$Race' WHERE CharacterID='$CharacterID'";
    return $conn->query($sql);
    $conn->close();
}
function createCharacter($conn,$Name,$EXP,$Class,$Race){
    $sql = "INSERT INTO AdventureDB.CharacterTable (Name, EXP, Class, Race) Value('$Name', '$EXP', '$Class', '$Race')";
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
function getID($conn,$String){
    $i=1;
    $sql = "SELECT ".$String."ID FROM AdventureDB.".$String."Table";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $Info[$i][0]=$row[$String."ID"];
            $i++;
        }
    }
    return $Info;
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
function getCharacterInfo($conn,$i,$CharInfo){
    $ID=$CharInfo[$i][0];
    $sql = "SELECT Name, EXP, Class, Race FROM AdventureDB.CharacterTable WHERE CharacterID = '$ID'";
    $result = $conn->query($sql);
    if ($result->num_rows != 0) {
        while($row = $result->fetch_assoc()) {
            $CharInfo[$i][2]=$row["Name"];
            $CharInfo[$i][3]=getCharLvl($row["EXP"]);
            $CharInfo[$i][4]=$row["EXP"];
            $CharInfo[$i][5]=$row["Class"];
            $CharInfo[$i][6]=$row["Race"];
        }
    }
    return $CharInfo;
}
function getMonsterInfo($conn,$i,$CharInfo){
    $ID=$CharInfo[$i][0];
    $sql = "SELECT Name, Size, Cr, Alignment, Type FROM AdventureDB.MonsterTable WHERE MonsterID = '$ID'";
    $result = $conn->query($sql);
    if ($result->num_rows != 0) {
        while($row = $result->fetch_assoc()) {
            $CharInfo[$ID][2]=$row["Name"];
            $CharInfo[$ID][3]=$row["Size"];
            $CharInfo[$ID][4]=$row["Cr"];
            $CharInfo[$ID][5]=$row["Alignment"];
            $CharInfo[$ID][6]=$row["Type"];
            $CharInfo[$ID][7]=getExp($row["Cr"]);
        }
    }
    return $CharInfo;
}
function getExp($Cr){
    $exp=200*$Cr;
    if($Cr>=2){$exp+=50*($Cr-1);}
    if($Cr>=4){$exp+=150*($Cr-3);}
    if($Cr==5){$exp+=100;}
    if($Cr>=5){$exp+=200*($Cr-4);}
    if($Cr>=8){$exp+=400*($Cr-7);}
    if($Cr>=9){$exp+=100*($Cr-8);}
    if($Cr==10){$exp-=200;}
    if($Cr>=12){$exp+=100*($Cr-11);}
    if($Cr>=13){$exp+=300*($Cr-12)+100;}
    if($Cr>=16){$exp+=500*($Cr-15);}
    if($Cr>=17){$exp+=1000;}
    if($Cr>=20){$exp+=1000*($Cr-19);}
    if($Cr>=21){$exp+=5000*($Cr-20);}
    if($Cr>=23){$exp+=1000*($Cr-22);}
    if($Cr>=24){$exp+=3000*($Cr-23);}
    if($Cr>=25){$exp+=1000*($Cr-24);}
    if($Cr>=26){$exp+=2000*($Cr-25);}
    if($Cr==30){$exp+=5000;}
    return $exp;
}
function getCharLvl($Exp){            
$Advancement=array(0,300,1200,3900,10400,24400,47400,81400,129400,193400,278400,378400,498400,638400,803400,998400,1223400,1488400,1793400,2148400);
    for ($i=0; $i<sizeof($Advancement); $i++){
        if($Exp < $Advancement[$i]){return $i;}
    }
}
function getCharExp($Lvl){
$Advancement=array(0,300,1200,3900,10400,24400,47400,81400,129400,193400,278400,378400,498400,638400,803400,998400,1223400,1488400,1793400,2148400);
     return $Advancement[$Lvl-1];
    
}
function getMulti($Amount){
    $Multi=1;
    if($Amount==2){$Multi=1.5;}
    if($Amount>=3){$Multi=2;}
    if($Amount>=7){$Multi=2.5;}
    if($Amount>=11){$Multi=3;}
    if($Amount>=15){$Multi=4;}
    return $Multi;
}
?>
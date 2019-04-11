<?php
//begynder sessionen 
session_start();
//manuel debug toggel.
$GLOBALS['debug'] = false;
if($GLOBALS['debug']){echo "<br>DEBUG: database.php included";}
//hvis debug er fra sætte error reporting også fra
else{error_reporting(E_ERROR | E_PARSE);}

//function til at lave alle databasen og alle tabellerne ud fra connectionen
function createAll($conn){
    createDatabase($conn);
    createCharacterTable($conn);
    createContractTable($conn);
    createLegendTable($conn);
    createPartyTable($conn);
    createEncounterTable($conn);
    createMonsterTable($conn);
    //scraper kun hvis der ikke er nogle monstere i MonsterTabelen
    if(getMax($conn,"MonsterID","MonsterTable")==0){scrapeMonster($conn);}
}
//laver connectionen og retunerer den.
function getConnection(){
    $conn = new mysqli("localhost", "root", "root");
    return $conn;
}
//laver databasen ud fra connectionen
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
//laver CharacterTabelen ud fra connection
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
//laver ContractTabelen ud fra connection
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
//laver LegendTabelen ud fra connection
function createLegendTable($conn){
    $sql = "CREATE TABLE AdventureDB.LegendTable (
    LegendID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    PartyID INT(6) NOT NULL,
    EncounterID INT(6) NOT NULL
    )";
    $ltCreated = $conn->query($sql);
    if($GLOBALS['debug']){
        if ($ltCreated) {
            echo "<br>DEBUG:LegendTable created successfully";
        } else {
            echo "<br>DEBUG:Error creating LegendTable: " . $conn->error;
        }
    }  
}
//laver PartyTabelen ud fra connection
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
//laver EncounterTabelen ud fra connection
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
//laver MonsterTabelen ud fra connection
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
//scraper hjemme siden dndbeyond for information omkring monstere og sætter dem ind i monster tablen
function scrapeMonster($conn){
    //øger time limiten før time out fra 30sec til 20min
    set_time_limit(1200);
    //inkludere scraping library
    include"simple_html_dom.php";
    //laver int og sætter det til 0
    $a = 0;
    //starter array
    $Info = [];
    //køre et forloop for hver side på hjemmesiden
    for ($p=1;$p<71;$p++){
        //sætter html til at holde hjemmeside filen til det givne side nummer
        $html = file_get_html('https://www.dndbeyond.com/monsters?page='.$p);
        //finder hver div i hjemmesidens sourcecode som har classen "listing-body" og laver et forloop for hver
        foreach($html->find('div') as $divBody){
            if($divBody->class === "listing-body"){
                //finder hver div infor den forrige div som har classen "info" og laver et forloop for hver
                //dette indeholder alle monsterne
                foreach($divBody->find('div') as $div){
                    if($div->class === "info"){
                        //dette indeholder alt informationen omkring et monster
                        //sætter n til 0
                        $n = 0;
                        //finder hver span indfor den nye div og laver et forloop for hver
                        foreach($div->find('span') as $span){
                        //sætter pladsen n i array lig plaintexten til den givne span
                            //teksten for cr hvis værdig er en brøk bliver omkrevet til decimaltal istedet
                            if($n==0){
                                $Info[$a][$n]=$span->plaintext;
                                if(($span->plaintext)=="1/8 "){$Info[$a][$n]=0.125;}
                                if(($span->plaintext)=="1/4 "){$Info[$a][$n]=0.25;}
                                if(($span->plaintext)=="1/2 "){$Info[$a][$n]=0.5;}
                            }
                            //"n"er til information som ikke skal blive brug bliver sprunget over
                            if($n!=0 && $n!=2 && $n!=4 && $n!=7 && $n!=8){$Info[$a][$n]=$span->plaintext;}
                            $n++;
                        }
                        $a++;
                    }
                }
            }
        }
    }
    //køre et forloop for støørelsen af arrayet
    for ($i=0; $i<sizeof($Info); $i++){
        //indsætter alt information fra arrayet til det givende tal ind i monstertabel 
        $sql = "INSERT AdventureDB.MonsterTable(Name, Size, Cr, Alignment, Type) VALUES ('".$Info[$i][1]."','".$Info[$i][5]."','".$Info[$i][0]."','".$Info[$i][6]."','".$Info[$i][3]."')";
        $msCreated = $conn->query($sql);
        if($GLOBALS['debug']){
            if ($msCreated) {
                echo "<br>DEBUG:Monsters scraped created successfully";
            } else {
                echo "<br>DEBUG:Error scraping: " . $conn->error;
            }
        }  
    }
}

//insætter et givent navn ind i en givent tabel i databsen og retunerer query
function createGroup($conn,$Name,$Group){
    $sql = "INSERT INTO AdventureDB.".$Group."Table (Name) Value('$Name')";
    return $conn->query($sql);
    $conn->close();
}
//fjerner et row fra en givent tabel ud fra et givent i ID og retunerer query
function deleteGroup($conn,$ID,$Group){
    $sql = "DELETE FROM AdventureDB.".$Group."Table WHERE ".$Group."ID='$ID'";
    return $conn->query($sql);
    $conn->close();
}
//updatere en characters navn exp class og race ud fra et givent id og de ny værdier og retunere query
function updateCharacter($conn,$CharacterID,$Name,$EXP,$Class,$Race){
    $sql = "UPDATE AdventureDB.CharacterTable SET Name = '$Name', EXP = '$EXP', Class = '$Class', Race = '$Race' WHERE CharacterID='$CharacterID'";
    return $conn->query($sql);
    $conn->close();
}
//insætter givent navn, exp, class og race ind i chractertabelen for at lave en nyt character med de givne informationer og retunere query
function createCharacter($conn,$Name,$EXP,$Class,$Race){
    $sql = "INSERT INTO AdventureDB.CharacterTable (Name, EXP, Class, Race) Value('$Name', '$EXP', '$Class', '$Race')";
    return $conn->query($sql);
    $conn->close();
}
//updatere en monsters navn size cr alignment og type ud fra et givent id og de ny værdier og retunere query
function updateMonster($conn,$MonsterID,$Name,$Size,$Cr,$Alignment,$Type){
    $sql = "UPDATE AdventureDB.MonsterTable SET Name = '$Name', Size = '$Size', Cr = '$Cr', Alignment = '$Alignment', Type = '$Type' WHERE MonsterID='$MonsterID'";
    return $conn->query($sql);
    $conn->close();
}
//insætter givent navn size cr alignment og typeind i chractertabelen for at lave en nyt monster med de givne informationer og retunere query
function createMonster($conn,$Name,$Size,$Cr,$Alignment,$Type){
    $sql = "INSERT INTO AdventureDB.MonsterTable (Name, Size, Cr, Alignment, Type) Value('$Name', '$Size', '$Cr', '$Alignment', '$Type')";
    return $conn->query($sql);
    $conn->close();
}
//vælger og retunerer navnet til et givent id fra en givent tabel
function getName($conn,$ID,$String){
    $sql = "SELECT Name FROM AdventureDB.".$String."Table WHERE ".$String."ID='$ID'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row["Name"];
        }
    }
}
//vælger og retunerer mængden af et givent objekt fra et givent tabel
function getMax($conn,$Object,$Table){
    $sql = "SELECT COUNT($Object) FROM AdventureDB.$Table";
    $result = $conn->query($sql);
    return $result->fetch_assoc()["COUNT($Object)"];
}
//vælger IDerne fra en given tabel og sætter dem in i et array så de har plasering 0 til et givent tal
//array bliver derefter retuneret
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
//vælger og retunerer summen af et Amount til et givent charID, GroupID og gruppe typpe fra contracttabelen 
function getAmount($conn,$ID,$GroupID,$Group){
    $sql = "SELECT SUM(Amount) FROM AdventureDB.ContractTable WHERE GroupID = '$GroupID' AND CharID = '$ID' AND Type = '$Group'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row["SUM(Amount)"];
        }
    }
}
//finder CharacterID fra et givent array med en givent tal, og vælger Navn, exp Class og race til IDet fra Charactertabelen
//værdierne sætter til det givende array der derefter retuneres
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
//finder MonsterID fra et givent array med en givent tal, og vælger Navn, size cr alignment og type til IDet fra Monstertabelen
//værdierne sætter til det givende array der derefter retuneres
function getMonsterInfo($conn,$i,$CharInfo){
    $ID=$CharInfo[$i][0];
    $sql = "SELECT Name, Size, Cr, Alignment, Type FROM AdventureDB.MonsterTable WHERE MonsterID = '$ID'";
    $result = $conn->query($sql);
    if ($result->num_rows != 0) {
        while($row = $result->fetch_assoc()) {
            $CharInfo[$i][2]=$row["Name"];
            $CharInfo[$i][3]=$row["Size"];
            $CharInfo[$i][4]=$row["Cr"];
            $CharInfo[$i][5]=$row["Alignment"];
            $CharInfo[$i][6]=$row["Type"];
            $CharInfo[$i][7]=getExp($row["Cr"]);
        }
    }
    return $CharInfo;
}
//finder den resulterende exp til et givent cr ud fra et konstant array
function getExp($Cr){
if($Cr<1){return $Cr*200;}
$Relation=array(200,450,700,1100,1800,2300,2900,3900,5000,5900,7200,8400,10000,11500,13000,15000,18000,20000,22000,25000,33000,41000,50000,62000,75000,90000,105000,120000,135000,155000);
    return $Relation[$Cr-1];
}
//finder det resulterende lvl til et givent exp, ud fra et konstant array 
function getCharLvl($Exp){            
$Advancement=array(0,300,1200,3900,10400,24400,47400,81400,129400,193400,278400,378400,498400,638400,803400,998400,1223400,1488400,1793400,2148400);
    for ($i=0; $i<sizeof($Advancement); $i++){
        if($Exp < $Advancement[$i]){return $i;}
    }
}
//finder det resulterende exp til et givent lvl, ud fra et konstant array 
function getCharExp($Lvl){
$Advancement=array(0,300,1200,3900,10400,24400,47400,81400,129400,193400,278400,378400,498400,638400,803400,998400,1223400,1488400,1793400,2148400);
     return $Advancement[$Lvl-1];
    
}
//finder det ruslterende multiplier til et givent amount, ud fra et konstant array
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
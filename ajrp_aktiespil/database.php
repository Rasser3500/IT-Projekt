<?php
$GLOBALS['debug'] = false; //Manuelt switch til debug

if($GLOBALS['debug']){
    echo "<br>DEBUG: database.php included";
}

//Her opsættes en masse funktioner til at lave handlinger i databasen, så de nemt kan kaldes andre steder fra.

    function getConnectionAndCreateAll(){
        $connect = new mysqli("localhost", "root","root");
        /*Nedenstående udkommenteret - kan bruges til debugging!!
        if ($connect->connect_error) {
            die("<br>Connection failed: " . $conn->connect_error);
        }
        echo "Connected successfully";*/
        createDatabase($connect);
        createUserTable($connect);
        createAktieTable($connect);
        createTransaktionsTable($connect);
        insertAktierHardcoded($connect);
        return $connect;
    }

    function createDatabase($connection){
        $sql = "CREATE DATABASE myDB";
        $dbCreated = $connection->query($sql);
        if($GLOBALS['debug']){
            if ($dbCreated) {
                echo "<br>DEBUG:Database created successfully";
            } else {
                echo "<br>DEBUG:Error creating database: " . $connection->error;
            }
        }
    }

    function createUser($connection, $navn, $password){
        $sql =  "INSERT INTO myDB.USERS (navn, password, formue) VALUES ('".$navn."','".$password."',1000)";
        $userCreated = $connection->query($sql);
        if($GLOBALS['debug']){
            if ($userCreated) {
                echo "<br>DEBUG:New record created successfully";
            } else {
                echo "<br>DEBUG: Error: " . $sql . "<br>" . $connection->error;
            }
        }
        return $userCreated;
    }

    function createUserTable($connection){
        $sql = "CREATE TABLE myDB.USERS (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, navn VARCHAR(30) NOT NULL, password VARCHAR(30) NOT NULL, formue DECIMAL(8,2))";
        $tbCreated = $connection->query($sql);
        if($GLOBALS['debug']){
            if ($tbCreated) {
                echo "<br>DEBUG:Table users created successfully";
            } else {
                echo "<br>DEBUG:Error creating users: " . $connection->error;
            }
        }
    }

    function createAktieTable($connection){
        $sql = "CREATE TABLE myDB.AKTIER (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, navn VARCHAR(30) NOT NULL, pris DECIMAL(8,2) NOT NULL)";
        $tbCreated = $connection->query($sql);
        if($GLOBALS['debug']){
            if ($tbCreated) {
                echo "<br>DEBUG:able aktier created successfully";
            } else {
                echo "<br>DEBUG:Error creating aktier: " . $connection->error;
            }
        }
    }

    function createTransaktionsTable($connection){
        $sql = "CREATE TABLE myDB.TRANSAKTIONER (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, user_id INT(6) UNSIGNED, aktie_id INT(6) UNSIGNED, antal INT(6), omkostning DECIMAL(8,2) NOT NULL, FOREIGN KEY (user_id) REFERENCES myDB.USERS(id), FOREIGN KEY (aktie_id) REFERENCES myDB.AKTIER(id))";
        $tbCreated = $connection->query($sql);
        if($GLOBALS['debug']){
            if ($tbCreated) {
                echo "<br>DEBUG:Table transaktioner created successfully";
            } else {
                echo "<br>DEBUG:Error creating transaktioner: " . $connection->error;
            }
        }
    }

    function insertAktierHardcoded($connection){
        $sql ="INSERT INTO myDB.AKTIER (`id`, `navn`, `pris`) VALUES (1, 'Aktie123', '123.00'), (2, 'Aktie1234', '1234.00'), (3, 'Aktie12345', '12345.00');";
        $tbCreated = $connection->query($sql);
        if($GLOBALS['debug']){
            if ($tbCreated) {
                echo "<br>DEBUG:Aktier inserted successfully";
            } else {
                echo "<br>DEBUG:Error insert in aktier: " . $connection->error;
            }
        }
    }

    function doesUserNameExists($connection, $navn){
        $sql = "SELECT * FROM myDB.USERS WHERE navn='".$navn."' LIMIT 1";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        if($GLOBALS['debug']){
            echo "<br>DEBUG: Check if  user  with PASSWORD exists" . $sql . " status(error):" . $connection->error;
        }
        return $row!=null;
    }

    function doesUserNameAndPasswordExists($connection, $navn, $password){
        $sql = "SELECT USERS.id FROM myDB.USERS WHERE password='".$password."' AND navn='".$navn."' LIMIT 1";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        if($GLOBALS['debug']){
            echo "<br>DEBUG: USER ID ".$row['id'];
            echo "<br>DEBUG: Check if  user  with NAME,PASSWORD exists sql:" . $sql . " " . $connection->error;
        }
        return $row != null ? $row['id']: null;
    }

    function getFormue($connection, $navn, $password){
        return 1000;
    }

    function getUserAktieOversigt($connection, $userId){
        $alle_transaktioner          = array();
        $unik_transaktioer           = array();

        $sql = "SELECT trans_id,aktie_id,aktie_navn,aktie_pris,SUM(antal) AS 'antal', SUM(omkostning) AS 'omkostning' FROM(
                SELECT 0 AS 'trans_id', id as 'aktie_id',aktier.navn AS 'aktie_navn' ,pris as 'aktie_pris',0 AS 'antal', 0 AS 'omkostning'
                FROM myDB.AKTIER

                UNION

                SELECT transaktioner.id AS 'trans_id', transaktioner.aktie_id, aktier.navn AS 'aktie_navn', aktier.pris as 'aktie_pris', transaktioner.antal,transaktioner.omkostning
                FROM myDB.TRANSAKTIONER, myDB.AKTIER
                WHERE
                transaktioner.aktie_id = aktier.id AND transaktioner.user_id =".$userId.") t GROUP BY aktie_id";

        $result = $connection->query($sql);

        $i = 0;
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                    $alle_transaktioner[$i] = $row;
                    $i++;
            }
        }

        if($GLOBALS['debug']){
                foreach($alle_transaktioner as $tranRow){
                    echo "<br>DEBUG: User transactions overview , row id:".$tranRow['trans_id'];
                }


        }

        return $alle_transaktioner;

    }

    function sellAktie($connection, $userid, $aktieId, $pris,$antal){
        $omkostning = -$pris*$antal;
        $antal      = -$antal;
        $sql ="INSERT INTO myDB.TRANSAKTIONER (id,`user_id`, `aktie_id`, `antal`, `omkostning`) VALUES (NULL,".$userid.", ".$aktieId.",".$antal.",".$omkostning.");";
        $tbCreated = $connection->query($sql);
        if($GLOBALS['debug']){
            echo "<br>DEBUG: SELL sql ".$sql;
            if ($tbCreated) {
                echo "<br>DEBUG:sell aktie successfully";
            } else {
                echo "<br>DEBUG:Error sell: " . $connection->error;
            }
        }
    }

    function kobAktie($connection, $userid, $aktieId, $pris){
        $sql ="INSERT INTO myDB.TRANSAKTIONER (`user_id`, `aktie_id`, `antal`, `omkostning`) VALUES (".$userid.", ".$aktieId.", 1, ".$pris.");";
        $tbCreated = $connection->query($sql);
        if($GLOBALS['debug']){
            echo "<br>DEBUG: køb sql ".$sql;
            if ($tbCreated) {
                echo "<br>DEBUG:dummy transaktion inserted successfully";
            } else {
                echo "<br>DEBUG:Error insert in transaktioner: " . $connection->error;
            }
        }
    }

?>

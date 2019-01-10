<?php
    session_start();
    include "database.php";

    $navn       = isset($_POST['navn'])     ?   $_POST['navn']      :   $_SESSION['navn'];
    $password   = isset($_POST['password']) ?   $_POST['password']  :   $_SESSION['password'];

    $connection             = getConnectionAndCreateAll();
    $brugerEksisterer       = false;

    if(doesUserNameAndPasswordExists($connection,$navn,$password)){
        echo "<br>Velkommen ".$navn;
        $brugerEksisterer   = true;
    }else if (doesUserNameExists($connection,$navn)){
        echo "<br>Der eksisterer allerede en bruger med dette navn - men password er forkert!";
        $brugerEksisterer   = false;
    }else{
        echo "<br>Bruger oprettet";
        $brugerEksisterer   = createUser($connection,$navn,$password);
    }

    if($brugerEksisterer){
        $_SESSION['navn']       = $navn;
        $_SESSION['password']   = $password;
        $_SESSION['connection'] = $connection;
        $_SESSION['user_id']    = doesUserNameAndPasswordExists($connection,$navn,$password);
        //Viser brugerens data - aktier osv.
        include "brugerSubSide.php";
    }

?>

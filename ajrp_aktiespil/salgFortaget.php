<?php
    session_start();
    include "database.php";
    $connect = getConnectionAndCreateAll(); //genopretter forbindelse her... af en eller anden grund mistede jeg den...
    sellAktie($connect, $_SESSION['user_id'], $_GET['aktie_id'], $_GET['pris'], $_GET['antal']);

    echo "Tillykke du har lavet et SALG!";
    echo "<a href='brugerSide.php'><button>Gå tilbage til brugerside</button></a>";
?>

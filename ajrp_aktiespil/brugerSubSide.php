<html>
<body>
<?php
//included i brugerSide...
//behøver ikke session_start();
//behøver ikke database.php

$transaktions   = getUserAktieOversigt($_SESSION['connection'], $_SESSION['user_id']);
$formue         = getFormue($_SESSION['connection'],$_SESSION['navn'],$_SESSION['password']);

echo "<br>------------------------------";

echo "<br><br><table border='1'>";
echo "<tr><th>Navn</th><th>Antal</th><th>Aktiepris</th><th>Købt for:</th></tr>";
foreach($transaktions as $row){
    echo "<tr>";
    if($row['antal']>=0){

        echo "  <td>".$row['aktie_navn']."</td>
                <td>".$row['antal']."</td>
                <td>".$row['aktie_pris']."</td>
                <td>".$row['omkostning']."</td>
                <td><a href='kobFortaget.php?pris=".$row['aktie_pris']."&aktie_id=".$row['aktie_id']."'><button>Køb</button></a></td>";
            if($row['antal']>0){
                echo "<td><a href='salgFortaget.php?pris=".$row['aktie_pris']."&aktie_id=".$row['aktie_id']."&antal=".$row['antal']."'><button>Sælg</button></a></td>";
            }
    }
    $formue = $formue - $row['omkostning'];
    echo "</tr>";
}
echo "</table>";

echo "<br>------------------------------";

echo "<br>Formue: ".$formue;

echo "<br>------------------------------";


?>

</body>
</html>

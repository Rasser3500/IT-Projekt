<html>
<?php
//inkludere alle database funktionerne.
include "database.php";
//får connectionen til databasen
$conn = getConnection();
//laver databasen og alle tabellerne
createAll($conn);
?>
<!--knap til homepage-->
<a href="homePage.php"><button>Ok</button></a>
</html>

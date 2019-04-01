<html>
<?php
include"database.php";
$conn=getConnection();
deleteGroup($conn,$_POST["Var"],$_POST["ID"])
?>
<a href="viewParties.php"><button>Ok</button></a>
</html>
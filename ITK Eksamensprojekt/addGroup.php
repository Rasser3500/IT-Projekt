<html>
<?php
include"database.php";
$conn=getConnection();
if(createGroup($conn,$_POST["Name"],$_POST["Var"])){
    echo "The ".$_POST["Var"]." ".$_POST["Name"]." has been created";
}
?>
<br>
<a href="viewParties.php"><button>Ok</button></a>
</html>